<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Writer\File\Xml;

use Akeneo\Component\Batch\Event\EventInterface;
use Akeneo\Component\Batch\Event\InvalidItemEvent;
use Akeneo\Component\Batch\Item\FileInvalidItem;
use Akeneo\Component\Batch\Item\FlushableInterface;
use Akeneo\Component\Batch\Item\InitializableInterface;
use Akeneo\Component\Batch\Item\InvalidItemInterface;
use Akeneo\Component\Batch\Job\JobParameters;
use Akeneo\Component\Batch\Job\JobRepositoryInterface;
use Akeneo\Component\Batch\Model\StepExecution;
use Akeneo\Component\Batch\Model\Warning;
use Akeneo\Component\Buffer\BufferFactory;
use Dnd\Bundle\GoogleManufacturerBundle\Exception\GoogleManufacturerException;
use Dnd\Bundle\GoogleManufacturerBundle\Model\GoogleImportExport;
use Dnd\Bundle\GoogleManufacturerBundle\Validator\Constraints\FieldValidator;
use Pim\Component\Catalog\Model\ChannelInterface;
use Pim\Component\Catalog\Repository\AttributeRepositoryInterface;
use Pim\Component\Catalog\Repository\ChannelRepositoryInterface;
use Pim\Component\Connector\ArrayConverter\ArrayConverterInterface;
use Pim\Component\Connector\Exception\InvalidItemFromViolationsException;
use Pim\Component\Connector\Writer\File\AbstractFileWriter;
use Pim\Component\Connector\Writer\File\ArchivableWriterInterface;
use Pim\Component\Connector\Writer\File\FlatItemBuffer;
use Pim\Component\Connector\Writer\File\FlatItemBufferFlusher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Writer
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Writer\File\Xml
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class Writer extends AbstractFileWriter implements
    ArchivableWriterInterface,
    InitializableInterface,
    FlushableInterface
{
    /** @var EventDispatcherInterface $eventDispatcher */
    private $eventDispatcher;
    /** @var JobRepositoryInterface $jobRepository */
    private $jobRepository;
    /** @var Validation $validator */
    private $validator;
    /** @var JobParameters $jobParameters */
    private $jobParameters;
    /** @var \DOMDocument $XMLRoot*/
    private $XMLRoot;
    /** @var \DOMNodeList $XMLItems */
    private $XMLItems;
    /** @var ArrayConverterInterface $arrayConverter */
    protected $arrayConverter;
    /** @var FlatItemBuffer $flatRowBuffer */
    protected $flatRowBuffer = null;
    /** @var FlatItemBufferFlusher $flusher */
    protected $flusher;
    /** @var BufferFactory $bufferFactory */
    protected $bufferFactory;
    /** @var ChannelRepositoryInterface $channelRepository*/
    protected $channelRepository;
    /** @var AttributeRepositoryInterface $attributeRepository */
    protected $attributeRepository;
    /** @var array $headers */
    protected $headers = [];
    /** @var array $writtenFiles */
    protected $writtenFiles = [];
    /** @var Filesystem $fs */
    protected $fs;

    /**
     * Writer constructor
     *
     * @param ArrayConverterInterface      $arrayConverter
     * @param BufferFactory                $bufferFactory
     * @param FlatItemBufferFlusher        $flusher
     * @param ChannelRepositoryInterface   $channelRepository
     * @param AttributeRepositoryInterface $attributeRepository
     * @param EventDispatcherInterface     $eventDispatcher
     * @param JobRepositoryInterface       $jobRepository
     */
    public function __construct(
        ArrayConverterInterface $arrayConverter,
        BufferFactory $bufferFactory,
        FlatItemBufferFlusher $flusher,
        ChannelRepositoryInterface $channelRepository,
        AttributeRepositoryInterface $attributeRepository,
        EventDispatcherInterface $eventDispatcher,
        JobRepositoryInterface $jobRepository
    ) {
        parent::__construct();

        $this->eventDispatcher     = $eventDispatcher;
        $this->jobRepository       = $jobRepository;
        $this->validator           = Validation::createValidator();
        $this->arrayConverter      = $arrayConverter;
        $this->bufferFactory       = $bufferFactory;
        $this->flusher             = $flusher;
        $this->channelRepository   = $channelRepository;
        $this->attributeRepository = $attributeRepository;
        $this->fs                  = new Filesystem();
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     * @throws \Exception
     */
    public function initialize()
    {
        if (null === $this->flatRowBuffer) {
            $this->flatRowBuffer = $this->bufferFactory->create();
        }
        try {
            $this
                ->initProperties()
                ->initExportFile()
                ->initXMLContent();
        } catch (\Exception $exception) {
            throw new \Exception('Internal error during the generation of XML export file. Reason: %s', $exception->getMessage());
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param array $products
     *
     * @return void
     */
    public function write(array $products)
    {
        /** @var ValidatorInterface $validator */
        $validator = Validation::createValidator();
        /** @var Collection $constraints */
        $constraints = $this->getConstraintValidation();
        /** @var array $product */
        foreach ($products as $product) {
            try {
                /** @var array $productNormalized */
                $productNormalized = $this->arrayConverter->convert($product, [
                    'jobParameters' => $this->jobParameters,
                    'attributeRepository' => $this->attributeRepository,
                    'validator' => $validator,
                    'constraints' => $constraints
                ]);
                $this->addXMLFlatItem(
                    $productNormalized,
                    $this->XMLRoot,
                    $this->XMLItems
                );
                file_put_contents($this->getPath(), $this->XMLRoot->saveXML());
            } catch (GoogleManufacturerException $googleManufacturerException) {
                $this->skipItemFromQueue($this->stepExecution, $this, $product, $googleManufacturerException);
            } catch (\Exception $exception) {
                throw $exception;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function flush()
    {
        $this->writtenFiles[$this->getPath()] = basename($this->getPath());
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getWrittenFiles()
    {
        return $this->writtenFiles;
    }

    /**
     * Description initProperties function
     *
     * @return Writer
     */
    private function initProperties(): Writer
    {
        $this->jobParameters = $this->stepExecution->getJobParameters()->all();

        return $this;
    }

    /**
     * Description getConstraintValidation function
     *
     * @return bool|Collection
     */
    private function getConstraintValidation()
    {
        if (!isset($this->jobParameters[GoogleImportExport::ATTR_ACCEPTANCE])) {
            return FieldValidator::getConstraints();
        }
        /** @var string $acceptance */
        $acceptance = $this->jobParameters[GoogleImportExport::ATTR_ACCEPTANCE];
        if (GoogleImportExport::ACCEPTANCE_LOW === $acceptance) {
            return false;
        }
        if (GoogleImportExport::ACCEPTANCE_HIGH === $acceptance) {
            return FieldValidator::getHighConstraints();
        }

        return FieldValidator::getConstraints();
    }

    /**
     * Initialize file and directory
     *
     * @return Writer
     * @throws \Exception
     */
    private function initExportFile(): Writer
    {
        try {
            /** @var string $filePath */
            $filePath = $this->getPath();
            if (!is_dir(dirname($filePath))) {
                $this->fs->mkdir(dirname($filePath));
            }
            if (!$this->fs->exists($filePath)) {
                $this->fs->touch($filePath, 0777);
            }
            file_get_contents($filePath, '');
        } catch (\Exception $exception) {
            throw new \Exception(sprintf('Folder or file cannot be create at path %s', $filePath));
        }

        return $this;
    }

    /**
     * Description initXMLContent function
     *
     * @return Writer
     * @throws GoogleManufacturerException
     */
    private function initXMLContent(): Writer
    {
        if (!is_null($this->XMLRoot)) {
            return $this;
        }
        $this->XMLRoot = new \DOMDocument('1.0', 'UTF-8');
        $this->XMLRoot->formatOutput = true;
        $this->XMLRoot->preserveWhiteSpace = false;

        $rss = $this->XMLRoot->createElement('rss');
        $rss->setAttribute('version', '2.0');
        $rss->setAttribute('xmlns:g', 'http://base.google.com/ns/1.0');
        $rss->appendChild($this->initChannel());

        $this->XMLRoot->appendChild($rss);

        file_put_contents($this->getPath(), $this->XMLRoot->saveXML());

        $this->XMLItems = $this->XMLRoot->getElementsByTagName('channel')->item(0);

        return $this;
    }

    /**
     * Description initChannel function
     *
     * @return \DOMElement
     * @throws GoogleManufacturerException
     */
    private function initChannel(): \DOMElement
    {
        /** @var \DOMElement $element */
        $element = $this->XMLRoot->createElement('channel');
        /** @var string $channel */
        $channel = isset($this->jobParameters['filters']['structure']['scope']) ? $this->jobParameters['filters']['structure']['scope'] : false;
        if (!$channel) {
            throw GoogleManufacturerException::missingChannel();
        }
        /** @var ChannelInterface $channel */
        $channel = $this->channelRepository->findOneByIdentifier($channel);
        if (!$channel) {
            return $element;
        }
        /** @var string $channel */
        $link = isset($this->jobParameters[GoogleImportExport::ATTR_URL]) ? $this->jobParameters[GoogleImportExport::ATTR_URL] : null;

        $element->appendChild($this->XMLRoot->createElement('title', $channel->getCode()));
        $element->appendChild($this->XMLRoot->createElement('link', $link));
        $element->appendChild($this->XMLRoot->createElement('description', $channel->getLabel()));

        return $element;
    }

    /**
     * Description addXmlNode function
     *
     * @param array        $convertedItem
     * @param \DOMDocument $XMLRoot
     * @param \DOMNode     $XMLItems
     *
     * @return void
     */
    private function addXMLFlatItem(array $convertedItem, \DOMDocument $XMLRoot, \DOMNode $XMLItems) : void
    {
        /** @var \DOMElement $xmlItem */
        $xmlItem = $XMLRoot->createElement('item');
        foreach ($convertedItem as $googleAttributeKey => $googleAttributeValue) {
            if (!$googleAttributeValue) {
                continue;
            }
            if (is_array($googleAttributeValue)) {
                /** @var string[] $googleGroupedAttributeValue */
                foreach ($googleAttributeValue as $googleGroupedAttributeValue) {
                    /** @var \DOMElement $node */
                    $node = $XMLRoot->createElement($googleAttributeKey);
                    /**
                     * @var string $groupedAttributeKey
                     * @var string $groupedAttributeValue
                     */
                    foreach ($googleGroupedAttributeValue as $groupedAttributeKey => $groupedAttributeValue) {
                        $subNode = $XMLRoot->createElement($groupedAttributeKey, htmlspecialchars($groupedAttributeValue));
                        $node->appendChild($subNode);
                    }
                    $xmlItem->appendChild($node);
                }

                continue;
            }

            $node = $XMLRoot->createElement($googleAttributeKey, htmlspecialchars($googleAttributeValue));
            $xmlItem->appendChild($node);
        }

        $XMLItems->appendChild($xmlItem);
    }

    /**
     * Description skipItemFromQueue function
     *
     * @param StepExecution               $stepExecution
     * @param mixed                       $element
     * @param array                       $item
     * @param GoogleManufacturerException $exception
     *
     * @return void
     */
    private function skipItemFromQueue(
        StepExecution $stepExecution,
        $element,
        array $item,
        GoogleManufacturerException $exception
    ) {
        /** @var InvalidItemFromViolationsException $invalidItem */
        $invalidItem = new InvalidItemFromViolationsException(
            $exception->getViolations() ?? new ConstraintViolationList(),
            new FileInvalidItem($item, ($this->stepExecution->getSummaryInfo('item_position'))),
            [$exception->getMessage()],
            0,
            $exception
        );
        /** @var Warning $warning */
        $warning = new Warning(
            $stepExecution,
            $exception->getMessage(),
            [],
            $invalidItem->getItem()->getInvalidData()
        );

        $this->jobRepository->addWarning($warning);
        $this->dispatchInvalidItemEvent(
            get_class($element),
            $invalidItem->getMessage(),
            $invalidItem->getMessageParameters(),
            $invalidItem->getItem()
        );
    }

    /**
     * Trigger an invalid item event
     *
     * @param string $class
     * @param string $reason
     * @param array  $reasonParameters
     * @param InvalidItemInterface  $item
     */
    private function dispatchInvalidItemEvent(
        string $class,
        string $reason,
        array $reasonParameters,
        InvalidItemInterface $item
    ): void {
        /** @var InvalidItemEvent $event */
        $event = new InvalidItemEvent($item, $class, $reason, $reasonParameters);

        $this->eventDispatcher->dispatch(EventInterface::INVALID_ITEM, $event);
    }
}

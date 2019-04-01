<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Writer\File\Xml;

use Akeneo\Component\Batch\Item\FlushableInterface;
use Akeneo\Component\Batch\Item\InitializableInterface;
use Akeneo\Component\Batch\Job\JobParameters;
use Akeneo\Component\Buffer\BufferFactory;
use Dnd\Bundle\GoogleManufacturerBundle\Exception\GoogleManufacturerException;
use Pim\Component\Catalog\Model\ChannelInterface;
use Pim\Component\Catalog\Repository\AttributeRepositoryInterface;
use Pim\Component\Catalog\Repository\ChannelRepositoryInterface;
use Pim\Component\Connector\ArrayConverter\ArrayConverterInterface;
use Pim\Component\Connector\Writer\File\AbstractFileWriter;
use Pim\Component\Connector\Writer\File\ArchivableWriterInterface;
use Pim\Component\Connector\Writer\File\FlatItemBuffer;
use Pim\Component\Connector\Writer\File\FlatItemBufferFlusher;
use Symfony\Component\Filesystem\Filesystem;

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
     */
    public function __construct(
        ArrayConverterInterface $arrayConverter,
        BufferFactory $bufferFactory,
        FlatItemBufferFlusher $flusher,
        ChannelRepositoryInterface $channelRepository,
        AttributeRepositoryInterface $attributeRepository
    ) {
        parent::__construct();

        $this->arrayConverter = $arrayConverter;
        $this->bufferFactory = $bufferFactory;
        $this->flusher = $flusher;
        $this->channelRepository = $channelRepository;
        $this->attributeRepository = $attributeRepository;
        $this->fs = new Filesystem();
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
        /** @var array $product */
        foreach ($products as $product) {
            /** @var array $productNormalized */
            $productNormalized = $this->arrayConverter->convert($product, [
                'jobParameters' => $this->jobParameters,
                'attributeRepository' => $this->attributeRepository
            ]);

            $this->addXMLFlatItem(
                $productNormalized,
                $this->XMLRoot,
                $this->XMLItems
            );
        }

        file_put_contents($this->getPath(), $this->XMLRoot->saveXML());
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
        $element->appendChild($this->XMLRoot->createElement('title', $channel->getCode()));
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
}

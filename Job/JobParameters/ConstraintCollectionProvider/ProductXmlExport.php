<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Job\JobParameters\ConstraintCollectionProvider;

use Akeneo\Component\Batch\Job\JobParameters\ConstraintCollectionProviderInterface;
use Dnd\Bundle\GoogleManufacturerBundle\Model\GoogleImportExport;
use Pim\Component\Catalog\Validator\Constraints\WritableDirectory;
use Pim\Component\Connector\Job\JobParameters\ConstraintCollectionProvider\ProductCsvExport as PimProductCsvExport;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class ProductXmlExport
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Job\JobParameters\ConstraintCollectionProvider
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class ProductXmlExport extends PimProductCsvExport
{
    /** @var string NO_OPTION */
    const NO_OPTION = 'NO_OPTION';
    /** @var int GTN_MIN_LENGTH */
    const GTN_MIN_LENGTH = 12;
    /** @var int GTN_MAX_LENGTH */
    const GTN_MAX_LENGTH = 14;
    /** @var TranslatorInterface $translator */
    protected $translator;

    /**
     * ProductXmlExport constructor
     *
     * @param ConstraintCollectionProviderInterface $simpleCsv
     * @param array                                 $supportedJobNames
     * @param TranslatorInterface                   $translator
     */
    public function __construct(
        ConstraintCollectionProviderInterface $simpleCsv,
        array $supportedJobNames,
        TranslatorInterface $translator
    ) {
        parent::__construct(
            $simpleCsv,
            $supportedJobNames
        );

        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     *
     * @return Collection
     */
    public function getConstraintCollection()
    {
        /** @var Collection $baseConstraint */
        $baseConstraint = parent::getConstraintCollection();
        /** @var [] $constraintFields */
        $constraintFields = $baseConstraint->fields;

        $constraintFields['filePath'] = [
            new NotBlank(['groups' => ['Execution', 'FileConfiguration']]),
            new WritableDirectory(['groups' => ['Execution', 'FileConfiguration']]),
            new Regex([
                'pattern' => '/.\.[a-z]{1,3}$/',
                'message' => 'The extension file must be a valid file'
            ])
        ];
        // General fields
        $constraintFields[GoogleImportExport::ATTR_URL]         = new Url();
        $constraintFields[GoogleImportExport::ATTR_ACCEPTANCE]  = new NotBlank();

        // Mandatory fields
        $constraintFields[GoogleImportExport::ATTR_IDENTIFIER]  = new NotBlank();
        $constraintFields[GoogleImportExport::ATTR_GTIN]        = new NotBlank();
        $constraintFields[GoogleImportExport::ATTR_TITLE]       = new NotBlank();
        $constraintFields[GoogleImportExport::ATTR_BRAND]       = new NotBlank();
        $constraintFields[GoogleImportExport::ATTR_DESCRIPTION] = new NotBlank();
        $constraintFields[GoogleImportExport::ATTR_MPN]         = new NotBlank();
        $constraintFields[GoogleImportExport::ATTR_IMAGE_LINK]  = new NotBlank();

        // Optional fields
        $constraintFields[GoogleImportExport::ATTR_MPN]                    = new Optional();
        $constraintFields[GoogleImportExport::ATTR_PRODUCT_NAME]           = new Optional();
        $constraintFields[GoogleImportExport::ATTR_PRODUCT_LINE]           = new Optional();
        $constraintFields[GoogleImportExport::ATTR_PRODUCT_TYPE]           = new Optional();
        $constraintFields[GoogleImportExport::ATTR_VIDEO_LINK]             = new Optional();
        $constraintFields[GoogleImportExport::ATTR_PRODUCT_PAGE_URL]       = new Optional();
        $constraintFields[GoogleImportExport::ATTR_ADDITIONAL_IMAGE_LINK]  = new Optional();
        $constraintFields[GoogleImportExport::ATTR_DISCLOSURE_DATE]        = new Optional();
        $constraintFields[GoogleImportExport::ATTR_RELEASE_DATE]           = new Optional();
        $constraintFields[GoogleImportExport::ATTR_SUGGESTED_RETAIL_PRICE] = new Optional();

        // Grouped fields
        $constraintFields[GoogleImportExport::ATTR_FEATURE_DESCRIPTIONS] = new Optional();
        $constraintFields[GoogleImportExport::ATTR_PRODUCT_DETAILS]      = new Optional();

        return new Collection(['fields' => $constraintFields]);
    }

    /**
     * Validate GTIN Code by :
     * > Type : Must be type "int"
     * > Length : Value must be between 12 and 14 digits
     *
     * @param string                    $payload
     * @param ExecutionContextInterface $context
     *
     * @return void
     */
    public function validateGTIN(string $payload, ExecutionContextInterface $context)
    {
        if (!is_numeric($payload)) {
            $context->addViolation($this->translator->trans('pim_catalog.constraint.103'));
        }
        /** @var int $length */
        $length = strlen($payload);
        if ($length < self::GTN_MIN_LENGTH || $length > self::GTN_MAX_LENGTH) {
            $context->addViolation(
                $this->translator->trans(
                    sprintf(
                        'The code must be a value between %s and %s digits. Given one is %s',
                        self::GTN_MIN_LENGTH,
                        self::GTN_MAX_LENGTH,
                        $length
                    )
                )
            );
        }
    }
}

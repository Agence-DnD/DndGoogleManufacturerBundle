<?php

declare(strict_types=1);

namespace Dnd\GoogleManufacturerBundle\Connector\Job\JobParameters\ConstraintCollectionProvider;

use Akeneo\Tool\Component\Batch\Job\JobParameters\ConstraintCollectionProviderInterface;
use Akeneo\Pim\Enrichment\Component\Product\Validator\Constraints\WritableDirectory;
use Akeneo\Pim\Enrichment\Component\Product\Connector\Job\JobParameters\ConstraintCollectionProvider\ProductCsvExport as PimProductCsvExport;
use Dnd\GoogleManufacturerBundle\Model\GoogleImportExport;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Url;

/**
 * Class ProductXmlExport
 *
 * @package   Dnd\GoogleManufacturerBundle\Connector\Job\JobParameters\ConstraintCollectionProvider
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class ProductXmlExport extends PimProductCsvExport
{
    /**
     * Description $translator field
     *
     * @var TranslatorInterface $translator
     */
    protected $translator;

    /**
     * ProductXmlExport constructor
     *
     * @param ConstraintCollectionProviderInterface $simpleCsv
     * @param string[]                              $supportedJobNames
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
    public function getConstraintCollection(): Collection
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
}

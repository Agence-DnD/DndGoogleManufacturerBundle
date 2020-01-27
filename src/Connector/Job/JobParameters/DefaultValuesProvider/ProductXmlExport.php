<?php

declare(strict_types=1);

namespace Dnd\GoogleManufacturerBundle\Connector\Job\JobParameters\DefaultValuesProvider;

use Dnd\GoogleManufacturerBundle\Model\GoogleImportExport;
use Akeneo\Pim\Enrichment\Component\Product\Connector\Job\JobParameters\DefaultValueProvider\ProductCsvExport as PimProductCsvExport;

/**
 * Class ProductXmlExport
 *
 * @package   Dnd\GoogleManufacturerBundle\Connector\Job\JobParameters\DefaultValuesProvider
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class ProductXmlExport extends PimProductCsvExport
{
    /**
     * {@inheritdoc}
     *
     * @return mixed[]
     */
    public function getDefaultValues(): array
    {
        /** @var array[] $parameters */
        $parameters = parent::getDefaultValues();
        $parameters['filePath'] = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'export_%job_label%_%datetime%.xml';

        return array_merge(
            $parameters, [
                // General fields
                GoogleImportExport::ATTR_ACCEPTANCE             => GoogleImportExport::ACCEPTANCE_MEDIUM,

                // Optional fields
                GoogleImportExport::ATTR_ADDITIONAL_IMAGE_LINK  => null,
                GoogleImportExport::ATTR_AGE_GROUP              => null,
                GoogleImportExport::ATTR_CAPACITY               => null,
                GoogleImportExport::ATTR_COLOR                  => null,
                GoogleImportExport::ATTR_COUNT                  => null,
                GoogleImportExport::ATTR_DISCLOSURE_DATE        => null,
                GoogleImportExport::ATTR_FLAVOR                 => null,
                GoogleImportExport::ATTR_FORMAT                 => null,
                GoogleImportExport::ATTR_GENDER                 => null,
                GoogleImportExport::ATTR_ITEM_GROUP_ID          => null,
                GoogleImportExport::ATTR_MATERIAL               => null,
                GoogleImportExport::ATTR_MPN                    => null,
                GoogleImportExport::ATTR_PATTERN                => null,
                GoogleImportExport::ATTR_PRODUCT_LINE           => null,
                GoogleImportExport::ATTR_PRODUCT_NAME           => null,
                GoogleImportExport::ATTR_PRODUCT_PAGE_URL       => null,
                GoogleImportExport::ATTR_PRODUCT_TYPE           => null,
                GoogleImportExport::ATTR_RELEASE_DATE           => null,
                GoogleImportExport::ATTR_SCENT                  => null,
                GoogleImportExport::ATTR_SIZE                   => null,
                GoogleImportExport::ATTR_SIZE_SYSTEM            => null,
                GoogleImportExport::ATTR_SIZE_TYPE              => null,
                GoogleImportExport::ATTR_SUGGESTED_RETAIL_PRICE => null,
                GoogleImportExport::ATTR_THEME                  => null,
                GoogleImportExport::ATTR_VIDEO_LINK             => null,
                GoogleImportExport::ATTR_RICH_PRODUCT_CONTENT   => null,
                // Grouped fields
                GoogleImportExport::ATTR_FEATURE_DESCRIPTIONS   => null,
                GoogleImportExport::ATTR_PRODUCT_DETAILS        => null
            ]
        );
    }
}

<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Job\JobParameters\DefaultValuesProvider;

use Dnd\Bundle\GoogleManufacturerBundle\Model\GoogleImportExport;
use Pim\Component\Connector\Job\JobParameters\DefaultValuesProvider\ProductCsvExport as PimProductCsvExport;

/**
 * Class ProductXmlExport
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Job\JobParameters\DefaultValuesProvider
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class ProductXmlExport extends PimProductCsvExport
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getDefaultValues()
    {
        /** @var array[] $parameters */
        $parameters = parent::getDefaultValues();

        return array_merge(
            $parameters, [
                // Optional fields
                GoogleImportExport::ATTR_MPN                    => null,
                GoogleImportExport::ATTR_PRODUCT_NAME           => null,
                GoogleImportExport::ATTR_PRODUCT_LINE           => null,
                GoogleImportExport::ATTR_PRODUCT_TYPE           => null,
                GoogleImportExport::ATTR_ADDITIONAL_IMAGE_LINK  => null,
                GoogleImportExport::ATTR_VIDEO_LINK             => null,
                GoogleImportExport::ATTR_PRODUCT_PAGE_URL       => null,
                GoogleImportExport::ATTR_DISCLOSURE_DATE        => null,
                GoogleImportExport::ATTR_RELEASE_DATE           => null,
                GoogleImportExport::ATTR_SUGGESTED_RETAIL_PRICE => null,
                // Grouped fields
                GoogleImportExport::ATTR_FEATURE_DESCRIPTIONS   => null,
                GoogleImportExport::ATTR_PRODUCT_DETAILS        => null
            ]
        );
    }
}

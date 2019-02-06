<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\ArrayConverter\StandardToFlat\Attribute;

use Dnd\Bundle\GoogleManufacturerBundle\Model\GoogleImportExport;
use Pim\Component\Connector\ArrayConverter\ArrayConverterInterface;
use Pim\Component\Connector\ArrayConverter\StandardToFlat\ProductLocalized as PimProductLocalized;

/**
 * Class Google
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\ArrayConverter\StandardToFlat\Attribute
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class Google extends PimProductLocalized implements ArrayConverterInterface
{
    /** @var string[] GOOGLE_MAPPING_ATTRIBUTES */
    const GOOGLE_MAPPING_ATTRIBUTES = [
        'g:id'                      => GoogleImportExport::ATTR_IDENTIFIER,
        'g:brand'                   => GoogleImportExport::ATTR_BRAND,
        'g:title'                   => GoogleImportExport::ATTR_TITLE,
        'g:gtin'                    => GoogleImportExport::ATTR_GTIN,
        'g:mpn'                     => GoogleImportExport::ATTR_MPN,
        'g:disclosure_date'         => GoogleImportExport::ATTR_DISCLOSURE_DATE,
        'g:release_date'            => GoogleImportExport::ATTR_RELEASE_DATE,
        'g:suggested_retail_price'  => GoogleImportExport::ATTR_SUGGESTED_RETAIL_PRICE,
        'g:product_name'            => GoogleImportExport::ATTR_PRODUCT_NAME,
        'g:product_line'            => GoogleImportExport::ATTR_PRODUCT_LINE,
        'g:product_type'            => GoogleImportExport::ATTR_PRODUCT_TYPE,
        'g:item_group_id'           => GoogleImportExport::ATTR_ITEM_GROUP_ID,
        'g:image_link'              => GoogleImportExport::ATTR_ADDITIONAL_IMAGE_LINK,
        'g:additional_image_link'   => GoogleImportExport::ATTR_ADDITIONAL_IMAGE_LINK,
        'g:video_link'              => GoogleImportExport::ATTR_VIDEO_LINK,
    ];

    /**
     * {@inheritdoc}
     *
     * @param array $productStandard
     * @param array $options
     *
     * @return array
     */
    public function convert(array $productStandard, array $options = [])
    {
        /** @var array $convertedItem */
        $convertedItem = parent::convert($productStandard);
        /** @var array|bool $jobParameters */
        $jobParameters = isset($options['jobParameters']) ? $options['jobParameters'] : false;
        if (!$jobParameters) {
            return $convertedItem;
        }

        $this->map($convertedItem, $jobParameters);
        $this->clean($convertedItem);

        return $convertedItem;
    }

    /**
     * Map attributes if value exist in product standard item
     *
     * @param array $convertedItem
     * @param array $jobParameters
     *
     * @return void
     */
    private function map(
        array &$convertedItem,
        array $jobParameters
    ): void {
        /**
         * @var string $googleKey
         * @var string $googleAttribute
         */
        foreach (self::GOOGLE_MAPPING_ATTRIBUTES as $googleKey => $googleAttribute) {
            if (!isset($jobParameters[$googleAttribute])) {
                continue;
            }
            /** @var string $pimAttribute */
            $pimAttribute = $jobParameters[$googleAttribute];
            if (isset($convertedItem[$pimAttribute])) {
                $convertedItem[$googleKey] = $convertedItem[$pimAttribute];
            }
        }
    }

    /**
     * Clean the attributes not needed in the exported file
     *
     * @param array $convertedItem
     *
     * @return void
     */
    private function clean(
        array &$convertedItem
    ): void {
        /**
         * @var string $googleKey
         * @var string $googleAttribute
         */
        foreach ($convertedItem as $attributeKey => $attributeValue) {
            if (true === array_key_exists($attributeKey, self::GOOGLE_MAPPING_ATTRIBUTES)) {
                continue;
            }
            unset($convertedItem[$attributeKey]);
        }
    }
}

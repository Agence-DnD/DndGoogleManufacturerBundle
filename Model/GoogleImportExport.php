<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Model;

/**
 * Class GoogleImportExport
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Model
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
final class GoogleImportExport
{
    /** @var string ACCEPTANCE_LOW */
    const ACCEPTANCE_LOW = 'low';
    /** @var string ACCEPTANCE_MEDIUM */
    const ACCEPTANCE_MEDIUM = 'medium';
    /** @var string ACCEPTANCE_HIGH */
    const ACCEPTANCE_HIGH = 'high';

    /** @var string GOOGLE_ATTR_ID */
    const GOOGLE_ATTR_ID = 'g:id';
    /** @var string GOOGLE_ATTR_BRAND */
    const GOOGLE_ATTR_BRAND = 'g:brand';
    /** @var string GOOGLE_ATTR_DESCRIPTION */
    const GOOGLE_ATTR_DESCRIPTION = 'g:description';
    /** @var string GOOGLE_ATTR_TITLE */
    const GOOGLE_ATTR_TITLE = 'g:title';
    /** @var string GOOGLE_ATTR_GTIN */
    const GOOGLE_ATTR_GTIN = 'g:gtin';
    /** @var string GOOGLE_ATTR_MPN */
    const GOOGLE_ATTR_MPN = 'g:mpn';
    /** @var string GOOGLE_ATTR_PAGE_URL */
    const GOOGLE_ATTR_PAGE_URL = 'g:product_page_url';
    /** @var string GOOGLE_ATTR_DISCLOSURE_DATE */
    const GOOGLE_ATTR_DISCLOSURE_DATE = 'g:disclosure_date';
    /** @var string GOOGLE_ATTR_RELEASE_DATE */
    const GOOGLE_ATTR_RELEASE_DATE = 'g:release_date';
    /** @var string GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE */
    const GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE = 'g:suggested_retail_price';
    /** @var string GOOGLE_ATTR_PRODUCT_NAME */
    const GOOGLE_ATTR_PRODUCT_NAME = 'g:product_name';
    /** @var string GOOGLE_ATTR_PRODUCT_LINE */
    const GOOGLE_ATTR_PRODUCT_LINE = 'g:product_line';
    /** @var string GOOGLE_ATTR_PRODUCT_TYPE */
    const GOOGLE_ATTR_PRODUCT_TYPE = 'g:product_type';
    /** @var string GOOGLE_ATTR_ITEM_GROUP_ID */
    const GOOGLE_ATTR_ITEM_GROUP_ID = 'g:item_group_id';
    /** @var string GOOGLE_ATTR_COLOR */
    const GOOGLE_ATTR_COLOR = 'g:color';
    /** @var string GOOGLE_ATTR_VIDEO_LINK */
    const GOOGLE_ATTR_VIDEO_LINK = 'g:video_link';
    /** @var string GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK */
    const GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK = 'g:additional_image_link';
    /** @var string GOOGLE_ATTR_PRODUCT_DETAIL */
    const GOOGLE_ATTR_PRODUCT_DETAIL = 'g:product_detail';
    /** @var string GOOGLE_ATTR_FEATURE_DESCRIPTION */
    const GOOGLE_ATTR_FEATURE_DESCRIPTION = 'g:feature_description';
    /** @var string GOOGLE_ATTR_HEADLINE */
    const GOOGLE_ATTR_HEADLINE = 'g:headline';
    /** @var string GOOGLE_ATTR_TEXT */
    const GOOGLE_ATTR_TEXT = 'g:text';
    /** @var string GOOGLE_ATTR_IMAGE_LINK */
    const GOOGLE_ATTR_IMAGE_LINK = 'g:image_link';
    /** @var string GOOGLE_ATTR_SECTION_NAME */
    const GOOGLE_ATTR_SECTION_NAME = 'g:section_name';
    /** @var string GOOGLE_ATTR_NAME */
    const GOOGLE_ATTR_NAME = 'g:attribute_name';
    /** @var string GOOGLE_ATTR_VALUE */
    const GOOGLE_ATTR_VALUE = 'g:attribute_value';

    /** @var string ATTR_URL */
    const ATTR_URL = 'googleUrl';
    /** @var string ATTR_ACCEPTANCE */
    const ATTR_ACCEPTANCE = 'googleAcceptance';
    /** @var string ATTR_IDENTIFIER */
    const ATTR_IDENTIFIER = 'googleId';
    /** @var string ATTR_BRAND */
    const ATTR_BRAND = 'googleBrand';
    /** @var string ATTR_TITLE */
    const ATTR_TITLE = 'googleTitle';
    /** @var string ATTR_DESCRIPTION */
    const ATTR_DESCRIPTION = 'googleDescription';
    /** @var string ATTR_GTIN */
    const ATTR_GTIN = 'googleGtin';
    /** @var string ATTR_MPN */
    const ATTR_MPN = 'googleMpn';
    /** @var string ATTR_DISCLOSURE_DATE */
    const ATTR_DISCLOSURE_DATE = 'googleDisclosureDate';
    /** @var string ATTR_RELEASE_DATE */
    const ATTR_RELEASE_DATE = 'googleReleaseDate';
    /** @var string ATTR_SUGGESTED_RETAIL_PRICE */
    const ATTR_SUGGESTED_RETAIL_PRICE = 'googleSuggestedRetailPrice';
    /** @var string ATTR_PRODUCT_NAME */
    const ATTR_PRODUCT_NAME = 'googleProductName';
    /** @var string ATTR_PRODUCT_LINE */
    const ATTR_PRODUCT_LINE = 'googleProductLine';
    /** @var string ATTR_PRODUCT_TYPE */
    const ATTR_PRODUCT_TYPE = 'googleProductType';
    /** @var string ATTR_ITEM_GROUP_ID */
    const ATTR_ITEM_GROUP_ID = 'googleItemGroupId';
    /** @var string ATTR_COLOR */
    const ATTR_COLOR = 'googleColor';
    /** @var string ATTR_IMAGE_LINK */
    const ATTR_IMAGE_LINK = 'googleImageLink';
    /** @var string ATTR_ADDITIONAL_IMAGE_LINK */
    const ATTR_ADDITIONAL_IMAGE_LINK = 'googleAdditionalImageLink';
    /** @var string ATTR_VIDEO_LINK */
    const ATTR_VIDEO_LINK = 'googleVideoLink';
    /** @var string ATTR_PRODUCT_PAGE_URL */
    const ATTR_PRODUCT_PAGE_URL = 'googleProductPageUrl';
    /** @var string ATTR_FEATURE_DESCRIPTIONS */
    const ATTR_FEATURE_DESCRIPTIONS = 'googleFeatureDescription';
    /** @var string ATTR_PRODUCT_DETAILS */
    const ATTR_PRODUCT_DETAILS = 'googleProductDetail';

    /** @var string ATTR_PRODUCT_FEATURE_DESCRIPTION_HEADLINE */
    const ATTR_PRODUCT_FEATURE_DESCRIPTION_HEADLINE = 'googleFeatureDescriptionHeadline';
    /** @var string ATTR_PRODUCT_FEATURE_DESCRIPTION_TEXT */
    const ATTR_PRODUCT_FEATURE_DESCRIPTION_TEXT = 'googleFeatureDescriptionText';
    /** @var string ATTR_PRODUCT_FEATURE_DESCRIPTION_IMAGE_LINK */
    const ATTR_PRODUCT_FEATURE_DESCRIPTION_IMAGE_LINK = 'googleFeatureDescriptionImageLink';
    /** @var string ATTR_PRODUCT_DETAILS_SECTION_NAME */
    const ATTR_PRODUCT_DETAILS_SECTION_NAME = 'googleProductDetailSectionName';
    /** @var string ATTR_PRODUCT_DETAILS_ATTRIBUTE_NAME */
    const ATTR_PRODUCT_DETAILS_ATTRIBUTE_NAME = 'googleProductDetailAttributeName';
    /** @var string ATTR_PRODUCT_DETAILS_ATTRIBUTE_VALUE */
    const ATTR_PRODUCT_DETAILS_ATTRIBUTE_VALUE = 'googleProductDetailAttributeValue';

    /**
     * Description getGroupedProductDetails function
     *
     * @return string[]
     */
    public function getGoogleProductDetail(): array
    {
        return [
            self::ATTR_PRODUCT_DETAILS_SECTION_NAME,
            self::ATTR_PRODUCT_DETAILS_ATTRIBUTE_NAME,
            self::ATTR_PRODUCT_DETAILS_ATTRIBUTE_VALUE
        ];
    }

    /**
     * Description getGroupedFeatureDescription function
     *
     * @return string[]
     */
    public static function getGoogleFeatureDescription(): array
    {
        return [
            self::ATTR_PRODUCT_FEATURE_DESCRIPTION_HEADLINE,
            self::ATTR_PRODUCT_FEATURE_DESCRIPTION_TEXT,
            self::ATTR_PRODUCT_FEATURE_DESCRIPTION_IMAGE_LINK
        ];
    }
}

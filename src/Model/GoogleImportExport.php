<?php

declare(strict_types=1);

namespace Dnd\GoogleManufacturerBundle\Model;

/**
 * Class GoogleImportExport
 *
 * @package   Dnd\GoogleManufacturerBundle\Model
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
final class GoogleImportExport
{
    /**
     * Description ACCEPTANCE_LOW const
     *
     * @var string ACCEPTANCE_LOW
     */
    public const ACCEPTANCE_LOW = 'low';
    /**
     * Description ACCEPTANCE_MEDIUM const
     *
     * @var string ACCEPTANCE_MEDIUM
     */
    public const ACCEPTANCE_MEDIUM = 'medium';
    /**
     * Description ACCEPTANCE_HIGH const
     *
     * @var string ACCEPTANCE_HIGH
     */
    public const ACCEPTANCE_HIGH = 'high';

    /**
     * Description GOOGLE_ATTR_BRAND const
     *
     * @var string GOOGLE_ATTR_BRAND
     */
    public const GOOGLE_ATTR_BRAND = 'g:brand';
    /**
     * Description GOOGLE_ATTR_DESCRIPTION const
     *
     * @var string GOOGLE_ATTR_DESCRIPTION
     */
    public const GOOGLE_ATTR_DESCRIPTION = 'g:description';
    /**
     * Description GOOGLE_ATTR_GTIN const
     *
     * @var string GOOGLE_ATTR_GTIN
     */
    public const GOOGLE_ATTR_GTIN = 'g:gtin';
    /**
     * Description GOOGLE_ATTR_ID const
     *
     * @var string GOOGLE_ATTR_ID
     */
    public const GOOGLE_ATTR_ID = 'g:id';
    /**
     * Description GOOGLE_ATTR_TITLE const
     *
     * @var string GOOGLE_ATTR_TITLE
     */
    public const GOOGLE_ATTR_TITLE = 'g:title';

    /**
     * Description GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK const
     *
     * @var string GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK
     */
    public const GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK = 'g:additional_image_link';
    /**
     * Description GOOGLE_ATTR_AGE_GROUP const
     *
     * @var string GOOGLE_ATTR_AGE_GROUP
     */
    public const GOOGLE_ATTR_AGE_GROUP = 'g:age_group';
    /**
     * Description GOOGLE_ATTR_CAPACITY const
     *
     * @var string GOOGLE_ATTR_CAPACITY
     */
    public const GOOGLE_ATTR_CAPACITY = 'g:capacity';
    /**
     * Description GOOGLE_ATTR_COLOR const
     *
     * @var string GOOGLE_ATTR_COLOR
     */
    public const GOOGLE_ATTR_COLOR = 'g:color';
    /**
     * Description GOOGLE_ATTR_COUNT const
     *
     * @var string GOOGLE_ATTR_COUNT
     */
    public const GOOGLE_ATTR_COUNT = 'g:count';
    /**
     * Description GOOGLE_ATTR_DISCLOSURE_DATE const
     *
     * @var string GOOGLE_ATTR_DISCLOSURE_DATE
     */
    public const GOOGLE_ATTR_DISCLOSURE_DATE = 'g:disclosure_date';
    /**
     * Description GOOGLE_ATTR_FLAVOR const
     *
     * @var string GOOGLE_ATTR_FLAVOR
     */
    public const GOOGLE_ATTR_FLAVOR= 'g:flavor';
    /**
     * Description GOOGLE_ATTR_FORMAT const
     *
     * @var string GOOGLE_ATTR_FORMAT
     */
    public const GOOGLE_ATTR_FORMAT= 'g:format';
    /**
     * Description GOOGLE_ATTR_GENDER const
     *
     * @var string GOOGLE_ATTR_GENDER
     */
    public const GOOGLE_ATTR_GENDER = 'g:gender';
    /**
     * Description GOOGLE_ATTR_ITEM_GROUP_ID const
     *
     * @var string GOOGLE_ATTR_ITEM_GROUP_ID
     */
    public const GOOGLE_ATTR_ITEM_GROUP_ID = 'g:item_group_id';
    /**
     * Description GOOGLE_ATTR_MATERIAL const
     *
     * @var string GOOGLE_ATTR_MATERIAL
     */
    public const GOOGLE_ATTR_MATERIAL = 'g:material';
    /**
     * Description GOOGLE_ATTR_MPN const
     *
     * @var string GOOGLE_ATTR_MPN
     */
    public const GOOGLE_ATTR_MPN = 'g:mpn';
    /**
     * Description GOOGLE_ATTR_PATTERN const
     *
     * @var string GOOGLE_ATTR_PATTERN
     */
    public const GOOGLE_ATTR_PATTERN = 'g:pattern';
    /**
     * Description GOOGLE_ATTR_PRODUCT_LINE const
     *
     * @var string GOOGLE_ATTR_PRODUCT_LINE
     */
    public const GOOGLE_ATTR_PRODUCT_LINE = 'g:product_line';
    /**
     * Description GOOGLE_ATTR_PRODUCT_NAME const
     *
     * @var string GOOGLE_ATTR_PRODUCT_NAME
     */
    public const GOOGLE_ATTR_PRODUCT_NAME = 'g:product_name';
    /**
     * Description GOOGLE_ATTR_PRODUCT_PAGE_URL const
     *
     * @var string GOOGLE_ATTR_PRODUCT_PAGE_URL
     */
    public const GOOGLE_ATTR_PRODUCT_PAGE_URL = 'g:product_page_url';
    /**
     * Description GOOGLE_ATTR_PRODUCT_TYPE const
     *
     * @var string GOOGLE_ATTR_PRODUCT_TYPE
     */
    public const GOOGLE_ATTR_PRODUCT_TYPE = 'g:product_type';
    /**
     * Description GOOGLE_ATTR_RELEASE_DATE const
     *
     * @var string GOOGLE_ATTR_RELEASE_DATE
     */
    public const GOOGLE_ATTR_RELEASE_DATE = 'g:release_date';
    /**
     * Description GOOGLE_ATTR_SCENT const
     *
     * @var string GOOGLE_ATTR_SCENT
     */
    public const GOOGLE_ATTR_SCENT = 'g:scent';
    /**
     * Description GOOGLE_ATTR_SIZE const
     *
     * @var string GOOGLE_ATTR_SIZE
     */
    public const GOOGLE_ATTR_SIZE = 'g:size';
    /**
     * Description GOOGLE_ATTR_SIZE_SYSTEM const
     *
     * @var string GOOGLE_ATTR_SIZE_SYSTEM
     */
    public const GOOGLE_ATTR_SIZE_SYSTEM = 'g:size_system';
    /**
     * Description GOOGLE_ATTR_SIZE_TYPE const
     *
     * @var string GOOGLE_ATTR_SIZE_TYPE
     */
    public const GOOGLE_ATTR_SIZE_TYPE = 'g:size_type';
    /**
     * Description GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE const
     *
     * @var string GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE
     */
    public const GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE = 'g:suggested_retail_price';
    /**
     * Description GOOGLE_ATTR_THEME const
     *
     * @var string GOOGLE_ATTR_THEME
     */
    public const GOOGLE_ATTR_THEME = 'g:theme';
    /**
     * Description GOOGLE_ATTR_VIDEO_LINK const
     *
     * @var string GOOGLE_ATTR_VIDEO_LINK
     */
    public const GOOGLE_ATTR_VIDEO_LINK = 'g:video_link';
    /**
     * Description GOOGLE_ATTR_RICH_PRODUCT_CONTENT const
     *
     * @var string GOOGLE_ATTR_RICH_PRODUCT_CONTENT
     */
    public const GOOGLE_ATTR_RICH_PRODUCT_CONTENT = 'g:rich_product_content';

    /**
     * Description GOOGLE_ATTR_PRODUCT_DETAIL const
     *
     * @var string GOOGLE_ATTR_PRODUCT_DETAIL
     */
    public const GOOGLE_ATTR_PRODUCT_DETAIL = 'g:product_detail';
    /**
     * Description GOOGLE_ATTR_FEATURE_DESCRIPTION const
     *
     * @var string GOOGLE_ATTR_FEATURE_DESCRIPTION
     */
    public const GOOGLE_ATTR_FEATURE_DESCRIPTION = 'g:feature_description';
    /**
     * Description GOOGLE_ATTR_HEADLINE const
     *
     * @var string GOOGLE_ATTR_HEADLINE
     */
    public const GOOGLE_ATTR_HEADLINE = 'g:headline';
    /**
     * Description GOOGLE_ATTR_TEXT const
     *
     * @var string GOOGLE_ATTR_TEXT
     */
    public const GOOGLE_ATTR_TEXT = 'g:text';
    /**
     * Description GOOGLE_ATTR_IMAGE_LINK const
     *
     * @var string GOOGLE_ATTR_IMAGE_LINK
     */
    public const GOOGLE_ATTR_IMAGE_LINK = 'g:image_link';
    /**
     * Description GOOGLE_ATTR_SECTION_NAME const
     *
     * @var string GOOGLE_ATTR_SECTION_NAME
     */
    public const GOOGLE_ATTR_SECTION_NAME = 'g:section_name';
    /**
     * Description GOOGLE_ATTR_NAME const
     *
     * @var string GOOGLE_ATTR_NAME
     */
    public const GOOGLE_ATTR_NAME = 'g:attribute_name';
    /**
     * Description GOOGLE_ATTR_VALUE const
     *
     * @var string GOOGLE_ATTR_VALUE
     */
    public const GOOGLE_ATTR_VALUE = 'g:attribute_value';

    /**
     * Description ATTR_URL const
     *
     * @var string ATTR_URL
     */
    public const ATTR_URL = 'googleUrl';
    /**
     * Description ATTR_ACCEPTANCE const
     *
     * @var string ATTR_ACCEPTANCE
     */
    public const ATTR_ACCEPTANCE = 'googleAcceptance';
    /**
     * Description ATTR_BRAND const
     *
     * @var string ATTR_BRAND
     */
    public const ATTR_BRAND = 'googleBrand';
    /**
     * Description ATTR_DESCRIPTION const
     *
     * @var string ATTR_DESCRIPTION
     */
    public const ATTR_DESCRIPTION = 'googleDescription';
    /**
     * Description ATTR_GTIN const
     *
     * @var string ATTR_GTIN
     */
    public const ATTR_GTIN = 'googleGtin';
    /**
     * Description ATTR_IDENTIFIER const
     *
     * @var string ATTR_IDENTIFIER
     */
    public const ATTR_IDENTIFIER = 'googleId';
    /**
     * Description ATTR_TITLE const
     *
     * @var string ATTR_TITLE
     */
    public const ATTR_TITLE = 'googleTitle';
    /**
     * Description ATTR_IMAGE_LINK const
     *
     * @var string ATTR_IMAGE_LINK
     */
    public const ATTR_IMAGE_LINK = 'googleImageLink';

    /**
     * Description ATTR_ADDITIONAL_IMAGE_LINK const
     *
     * @var string ATTR_ADDITIONAL_IMAGE_LINK
     */
    public const ATTR_ADDITIONAL_IMAGE_LINK = 'googleAdditionalImageLink';
    /**
     * Description ATTR_AGE_GROUP const
     *
     * @var string ATTR_AGE_GROUP
     */
    public const ATTR_AGE_GROUP = 'googleAgeGroup';
    /**
     * Description ATTR_CAPACITY const
     *
     * @var string ATTR_CAPACITY
     */
    public const ATTR_CAPACITY = 'googleCapacity';
    /**
     * Description ATTR_COLOR const
     *
     * @var string ATTR_COLOR
     */
    public const ATTR_COLOR = 'googleColor';
    /**
     * Description ATTR_COUNT const
     *
     * @var string ATTR_COUNT
     */
    public const ATTR_COUNT = 'googleCount';
    /**
     * Description ATTR_DISCLOSURE_DATE const
     *
     * @var string ATTR_DISCLOSURE_DATE
     */
    public const ATTR_DISCLOSURE_DATE = 'googleDisclosureDate';
    /**
     * Description ATTR_FLAVOR const
     *
     * @var string ATTR_FLAVOR
     */
    public const ATTR_FLAVOR = 'googleFlavor';
    /**
     * Description ATTR_FORMAT const
     *
     * @var string ATTR_FORMAT
     */
    public const ATTR_FORMAT = 'googleFormat';
    /**
     * Description ATTR_GENDER const
     *
     * @var string ATTR_GENDER
     */
    public const ATTR_GENDER = 'googleGender';
    /**
     * Description ATTR_ITEM_GROUP_ID const
     *
     * @var string ATTR_ITEM_GROUP_ID
     */
    public const ATTR_ITEM_GROUP_ID = 'googleItemGroupId';
    /**
     * Description ATTR_MATERIAL const
     *
     * @var string ATTR_MATERIAL
     */
    public const ATTR_MATERIAL = 'googleMaterial';
    /**
     * Description ATTR_MPN const
     *
     * @var string ATTR_MPN
     */
    public const ATTR_MPN = 'googleMpn';
    /**
     * Description ATTR_PATTERN const
     *
     * @var string ATTR_PATTERN
     */
    public const ATTR_PATTERN = 'googlePattern';
    /**
     * Description ATTR_PRODUCT_LINE const
     *
     * @var string ATTR_PRODUCT_LINE
     */
    public const ATTR_PRODUCT_LINE = 'googleProductLine';
    /**
     * Description ATTR_PRODUCT_NAME const
     *
     * @var string ATTR_PRODUCT_NAME
     */
    public const ATTR_PRODUCT_NAME = 'googleProductName';
    /**
     * Description ATTR_PRODUCT_PAGE_URL const
     *
     * @var string ATTR_PRODUCT_PAGE_URL
     */
    public const ATTR_PRODUCT_PAGE_URL = 'googleProductPageUrl';
    /**
     * Description ATTR_PRODUCT_TYPE const
     *
     * @var string ATTR_PRODUCT_TYPE
     */
    public const ATTR_PRODUCT_TYPE = 'googleProductType';
    /**
     * Description ATTR_RELEASE_DATE const
     *
     * @var string ATTR_RELEASE_DATE
     */
    public const ATTR_RELEASE_DATE = 'googleReleaseDate';
    /**
     * Description ATTR_SCENT const
     *
     * @var string ATTR_SCENT
     */
    public const ATTR_SCENT = 'googleScent';
    /**
     * Description ATTR_SIZE const
     *
     * @var string ATTR_SIZE
     */
    public const ATTR_SIZE = 'googleSize';
    /**
     * Description ATTR_SIZE_SYSTEM const
     *
     * @var string ATTR_SIZE_SYSTEM
     */
    public const ATTR_SIZE_SYSTEM = 'googleSizeSystem';
    /**
     * Description ATTR_SIZE_TYPE const
     *
     * @var string ATTR_SIZE_TYPE
     */
    public const ATTR_SIZE_TYPE = 'googleSizeType';
    /**
     * Description ATTR_SUGGESTED_RETAIL_PRICE const
     *
     * @var string ATTR_SUGGESTED_RETAIL_PRICE
     */
    public const ATTR_SUGGESTED_RETAIL_PRICE = 'googleSuggestedRetailPrice';
    /**
     * Description ATTR_THEME const
     *
     * @var string ATTR_THEME
     */
    public const ATTR_THEME = 'googleTheme';
    /**
     * Description ATTR_VIDEO_LINK const
     *
     * @var string ATTR_VIDEO_LINK
     */
    public const ATTR_VIDEO_LINK = 'googleVideoLink';
    /**
     * Description ATTR_RICH_PRODUCT_CONTENT const
     *
     * @var string ATTR_RICH_PRODUCT_CONTENT
     */
    public const ATTR_RICH_PRODUCT_CONTENT = 'googleRichProductContent';
    /**
     * Description ATTR_FEATURE_DESCRIPTIONS const
     *
     * @var string ATTR_FEATURE_DESCRIPTIONS
     */
    public const ATTR_FEATURE_DESCRIPTIONS = 'googleFeatureDescription';
    /**
     * Description ATTR_PRODUCT_DETAILS const
     *
     * @var string ATTR_PRODUCT_DETAILS
     */
    public const ATTR_PRODUCT_DETAILS = 'googleProductDetail';

    /**
     * Description ATTR_PRODUCT_FEATURE_DESCRIPTION_HEADLINE const
     *
     * @var string ATTR_PRODUCT_FEATURE_DESCRIPTION_HEADLINE
     */
    public const ATTR_PRODUCT_FEATURE_DESCRIPTION_HEADLINE = 'googleFeatureDescriptionHeadline';
    /**
     * Description ATTR_PRODUCT_FEATURE_DESCRIPTION_TEXT const
     *
     * @var string ATTR_PRODUCT_FEATURE_DESCRIPTION_TEXT
     */
    public const ATTR_PRODUCT_FEATURE_DESCRIPTION_TEXT = 'googleFeatureDescriptionText';
    /**
     * Description ATTR_PRODUCT_FEATURE_DESCRIPTION_IMAGE_LINK const
     *
     * @var string ATTR_PRODUCT_FEATURE_DESCRIPTION_IMAGE_LINK
     */
    public const ATTR_PRODUCT_FEATURE_DESCRIPTION_IMAGE_LINK = 'googleFeatureDescriptionImageLink';
    /**
     * Description ATTR_PRODUCT_DETAILS_SECTION_NAME const
     *
     * @var string ATTR_PRODUCT_DETAILS_SECTION_NAME
     */
    public const ATTR_PRODUCT_DETAILS_SECTION_NAME = 'googleProductDetailSectionName';
    /**
     * Description ATTR_PRODUCT_DETAILS_ATTRIBUTE_NAME const
     *
     * @var string ATTR_PRODUCT_DETAILS_ATTRIBUTE_NAME
     */
    public const ATTR_PRODUCT_DETAILS_ATTRIBUTE_NAME = 'googleProductDetailAttributeName';
    /**
     * Description ATTR_PRODUCT_DETAILS_ATTRIBUTE_VALUE const
     *
     * @var string ATTR_PRODUCT_DETAILS_ATTRIBUTE_VALUE
     */
    public const ATTR_PRODUCT_DETAILS_ATTRIBUTE_VALUE = 'googleProductDetailAttributeValue';

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

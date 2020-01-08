<?php

declare(strict_types=1);

namespace Dnd\Bundle\GoogleManufacturerBundle\Validator\Constraints;

use Dnd\Bundle\GoogleManufacturerBundle\Model\GoogleImportExport;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class FieldValidator
 *
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Validator\Constraints
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class FieldValidator
{
    /**
     * Description getConstraints function
     *
     * @return Collection
     */
    public static function getConstraints(): Collection
    {
        return new Collection([
            // Mandatory
            GoogleImportExport::GOOGLE_ATTR_ID => [
                new NotBlank(),
                new Length(['max' => 50])
            ],
            GoogleImportExport::GOOGLE_ATTR_GTIN => [
                new NotBlank(),
                new Callback(['callback' => [__CLASS__, 'validGoogleGTIN']])
            ],
            GoogleImportExport::GOOGLE_ATTR_TITLE => [
                new NotBlank()
            ],
            GoogleImportExport::GOOGLE_ATTR_BRAND => [
                new NotBlank()
            ],
            GoogleImportExport::GOOGLE_ATTR_DESCRIPTION => [
                new NotBlank()
            ],
            GoogleImportExport::GOOGLE_ATTR_IMAGE_LINK => [
                new NotBlank(),
                new Url()
            ],
            // Optional
            GoogleImportExport::GOOGLE_ATTR_MPN => [
                new Optional([
                    new Length(['max' => 70])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_NAME => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_LINE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_TYPE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK => [
                new Optional([
                    new Type('string'),
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_VIDEO_LINK => [
                new Optional([
                    new Type('string'),
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_PAGE_URL => [
                new Optional([
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_DISCLOSURE_DATE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_RELEASE_DATE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE => [
                new Optional()
            ],
            // Grouped
            GoogleImportExport::GOOGLE_ATTR_FEATURE_DESCRIPTION => new Optional([
                new Type('array'),
                new All([
                    new Collection([
                        GoogleImportExport::GOOGLE_ATTR_HEADLINE => [
                            new Length(['max' => 140])
                        ],
                        GoogleImportExport::GOOGLE_ATTR_TEXT => [
                            new Optional()
                        ],
                        GoogleImportExport::GOOGLE_ATTR_IMAGE_LINK => [
                            new Optional()
                        ]
                    ])
                ])
            ]),
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_DETAIL => new Optional([
                new Type('array'),
                new All([
                    new Collection([
                        GoogleImportExport::GOOGLE_ATTR_SECTION_NAME => [
                            new NotBlank()
                        ],
                        GoogleImportExport::GOOGLE_ATTR_NAME => [
                            new NotBlank()
                        ],
                        GoogleImportExport::GOOGLE_ATTR_VALUE => [
                            new Optional()
                        ]
                    ])
                ])
            ]),
        ]);
    }

    /**
     * Description getConstraints function
     *
     * @return Collection
     */
    public static function getHighConstraints(): Collection
    {
        return new Collection([
            // Mandatory
            GoogleImportExport::GOOGLE_ATTR_ID => [
                new NotBlank(),
                new Length(['max' => 50])
            ],
            GoogleImportExport::GOOGLE_ATTR_GTIN => [
                new NotBlank(),
                new Callback(['callback' => [__CLASS__, 'validGoogleGTIN']])
            ],
            GoogleImportExport::GOOGLE_ATTR_TITLE => [
                new NotBlank(),
                new Length(['min' => 40, 'max' => 140])
            ],
            GoogleImportExport::GOOGLE_ATTR_BRAND => [
                new NotBlank()
            ],
            GoogleImportExport::GOOGLE_ATTR_DESCRIPTION => [
                new NotBlank(),
                new Length(['min' => 500, 'max' => 1500])
            ],
            GoogleImportExport::GOOGLE_ATTR_IMAGE_LINK => [
                new NotBlank(),
                new Url()
            ],
            // Optional
            GoogleImportExport::GOOGLE_ATTR_MPN => [
                new Optional([
                    new Length(['max' => 70])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_NAME => [
                new Optional([
                    new Length(['min' => 40, 'max' => 140])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_LINE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_TYPE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK => [
                new Optional([
                    new Type('string'),
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_VIDEO_LINK => [
                new Optional([
                    new Type('string'),
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_PAGE_URL => [
                new Optional([
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_DISCLOSURE_DATE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_RELEASE_DATE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE => [
                new Optional()
            ],
            // Grouped
            GoogleImportExport::GOOGLE_ATTR_FEATURE_DESCRIPTION => new Optional([
                new Type('array'),
                new All([
                    new Collection([
                        GoogleImportExport::GOOGLE_ATTR_HEADLINE => [
                            new Length(['max' => 140])
                        ],
                        GoogleImportExport::GOOGLE_ATTR_TEXT => [
                            new Optional()
                        ],
                        GoogleImportExport::GOOGLE_ATTR_IMAGE_LINK => [
                            new Optional()
                        ]
                    ])
                ])
            ]),
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_DETAIL => new Optional([
                new Type('array'),
                new All([
                    new Collection([
                        GoogleImportExport::GOOGLE_ATTR_SECTION_NAME => [
                            new NotBlank()
                        ],
                        GoogleImportExport::GOOGLE_ATTR_NAME => [
                            new NotBlank()
                        ],
                        GoogleImportExport::GOOGLE_ATTR_VALUE => [
                            new Optional()
                        ]
                    ])
                ])
            ]),
        ]);
    }

    /**
     * Description validGoogleGTIN function
     *
     * @param mixed                     $gtin
     * @param ExecutionContextInterface $context
     *
     * @return void
     */
    public static function validGoogleGTIN($gtin, ExecutionContextInterface $context): void
    {
        /** @var int $length */
        $length = strlen($gtin);

        if (
            8 == $length ||
            12 == $length ||
            13 == $length ||
            14 == $length
        ) {
            return;
        }

        $context
            ->buildViolation('GTIN code must be a digit of 8, 12, 13 or 14 numbers.')
            ->addViolation();
    }
}

<?php

declare(strict_types=1);

namespace Dnd\GoogleManufacturerBundle\Validator\Constraints;

use Dnd\GoogleManufacturerBundle\Model\GoogleImportExport;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class FieldValidator
 *
 * @package   Dnd\GoogleManufacturerBundle\Validator\Constraints
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
            GoogleImportExport::GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_AGE_GROUP => [
                new Optional([
                    new Choice(['newborn', 'infant', 'toddler', 'kids', 'adult', 'nourrissons', 'bébés', 'tout-petits', 'enfants', 'adultes'])
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_CAPACITY => [
                new Optional([
                    new Regex([
                        'pattern' => '/\d+\s+(Mo|Go|To)/',
                        'match'   => true,
                        'message' => 'Value must follow this format: Number + Metric. Example: 16 Go',
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_COLOR => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_COUNT => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_DISCLOSURE_DATE => [
                new Optional([
                    new DateTime([
                        'format'  => 'Y-m-d',
                        'message' => 'Date format must be YYYY-MM-DD.'
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_FLAVOR => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_GENDER => [
                new Optional([
                    new Choice(['male', 'female', 'unisex'])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_ITEM_GROUP_ID => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_MATERIAL => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_MPN => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PATTERN => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_LINE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_NAME => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_TYPE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_PAGE_URL => [
                new Optional([
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_RELEASE_DATE => [
                new Optional([
                    new DateTime([
                        'format'  => 'Y-m-d',
                        'message' => 'Date format must be YYYY-MM-DD.'
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_SCENT => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_SIZE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_SIZE_SYSTEM => [
                new Optional([
                    new Choice([
                        'AU',
                        'BR',
                        'CN',
                        'CN (China)',
                        'DE',
                        'EU',
                        'FR',
                        'IT',
                        'JP',
                        'MEX',
                        'UK',
                        'US'
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_SIZE_TYPE => [
                new Optional([
                    new Choice([
                        'standard',
                        'petite taille femme',
                        'grande taille',
                        'maternité',
                        'regular',
                        'petite',
                        'oversize',
                        'maternity'
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_THEME => [
                new Optional()
            ],
            GoogleImportExport::GOOGLE_ATTR_VIDEO_LINK => [
                new Optional([
                    new Type('string'),
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_RICH_PRODUCT_CONTENT => [
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
                new NotBlank(),
                new Length(['min' => 1, 'max' => 70])
            ],
            GoogleImportExport::GOOGLE_ATTR_DESCRIPTION => [
                new NotBlank(),
                new Length(['min' => 1, 'max' => 1000])
            ],
            GoogleImportExport::GOOGLE_ATTR_IMAGE_LINK => [
                new NotBlank(),
                new Url(),
                new Length(['min' => 0, 'max' => 2000]),
            ],
            // Optional
            GoogleImportExport::GOOGLE_ATTR_ADDITIONAL_IMAGE_LINK => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 2000]),
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_AGE_GROUP => [
                new Optional([
                    new Choice(['newborn', 'infant', 'toddler', 'kids', 'adult', 'nourrissons', 'bébés', 'tout-petits', 'enfants', 'adultes'])
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_CAPACITY => [
                new Optional([
                    new Regex([
                        'pattern' => '/\d+\s+(Mo|Go|To)/',
                        'match'   => true,
                        'message' => 'Value must follow this format: Number + Metric (eg: 16 Go).',
                    ])
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_COLOR => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_COUNT => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_DISCLOSURE_DATE => [
                new Optional([
                    new DateTime([
                        'format'  => 'Y-m-d',
                        'message' => 'Date format must be YYYY-MM-DD.'
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_FLAVOR => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_FORMAT => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_GENDER => [
                new Optional([
                    new Choice(['male', 'female', 'unisex'])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_ITEM_GROUP_ID => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 1, 'max' => 50]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_MATERIAL => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_MPN => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PATTERN => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_LINE => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_NAME => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_TYPE => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_PRODUCT_PAGE_URL => [
                new Optional([
                    new Url(),
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 2000]),
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_RELEASE_DATE => [
                new Optional([
                    new DateTime([
                        'format'  => 'Y-m-d',
                        'message' => 'Date format must be YYYY-MM-DD.'
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_SCENT => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_SIZE => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_SIZE_SYSTEM => [
                new Optional([
                    new Choice([
                        'AU',
                        'BR',
                        'CN',
                        'CN (China)',
                        'DE',
                        'EU',
                        'FR',
                        'IT',
                        'JP',
                        'MEX',
                        'UK',
                        'US'
                    ])
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_SIZE_TYPE => [
                new Optional([
                    new Choice([
                        'standard',
                        'petite taille femme',
                        'grande taille',
                        'maternité',
                        'regular',
                        'petite',
                        'oversize',
                        'maternity'
                    ])
                ])            ],
            GoogleImportExport::GOOGLE_ATTR_SUGGESTED_RETAIL_PRICE => [
                new Optional([
                    new Type('float'),
                    new Length(['max' => 50]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_THEME => [
                new Optional([
                    new Type('string'),
                    new Length(['min' => 0, 'max' => 1000]),
                ])
            ],
            GoogleImportExport::GOOGLE_ATTR_VIDEO_LINK => [
                new Optional([
                    new Type('string'),
                    new Url()
                ]),
            ],
            GoogleImportExport::GOOGLE_ATTR_RICH_PRODUCT_CONTENT => [
                new Optional(new Optional([
                    new Type('string')
                ]))
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
                            new Optional([
                                new Length(['min'=> 250, 'max' => 700])
                            ])
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
                            new Optional([
                                new Length(['max' => 140])
                            ])
                        ],
                        GoogleImportExport::GOOGLE_ATTR_NAME => [
                            new Optional([
                                new Length(['max' => 140])
                            ])
                        ],
                        GoogleImportExport::GOOGLE_ATTR_VALUE => [
                            new Optional([
                                new Length(['max' => 1000])
                            ])
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

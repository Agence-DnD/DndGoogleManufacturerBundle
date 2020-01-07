<?php

declare(strict_types=1);

namespace Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest;

use Akeneo\Pim\Enrichment\Bundle\Doctrine\ORM\Query\AttributeIsAFamilyVariantAxis;
use Akeneo\Pim\Enrichment\Bundle\Filter\ObjectFilterInterface;
use Akeneo\Pim\Structure\Component\Factory\AttributeFactory;
use Akeneo\Pim\Structure\Component\Model\AttributeInterface;
use Akeneo\Pim\Structure\Component\Repository\AttributeRepositoryInterface;
use Akeneo\Tool\Component\Localization\Localizer\LocalizerInterface;
use Akeneo\Tool\Component\StorageUtils\Remover\RemoverInterface;
use Akeneo\Tool\Component\StorageUtils\Repository\SearchableRepositoryInterface;
use Akeneo\Tool\Component\StorageUtils\Saver\SaverInterface;
use Akeneo\Tool\Component\StorageUtils\Updater\ObjectUpdaterInterface;
use Akeneo\UserManagement\Bundle\Context\UserContext;
use Akeneo\Pim\Structure\Bundle\Controller\InternalApi\AttributeController as PimAttributeController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AttributeController
 *
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class AttributeController extends PimAttributeController
{
    /**
     * Description $translator field
     *
     * @var TranslatorInterface $translator
     */
    private $translator;
    /**
     * Description $userContext field
     *
     * @var UserContext $userContext
     */
    private $userContext;
    /**
     * Description $lightAttributeNormalizer field
     *
     * @var NormalizerInterface $lightAttributeNormalizer
     */
    private $lightAttributeNormalizer;

    /**
     * AttributeController constructor
     *
     * @param AttributeRepositoryInterface  $attributeRepository
     * @param NormalizerInterface           $normalizer
     * @param TokenStorageInterface         $tokenStorage
     * @param ObjectFilterInterface         $attributeFilter
     * @param SearchableRepositoryInterface $attributeSearchRepository
     * @param ObjectUpdaterInterface        $updater
     * @param ValidatorInterface            $validator
     * @param SaverInterface                $saver
     * @param RemoverInterface              $remover
     * @param AttributeFactory              $factory
     * @param UserContext                   $userContext
     * @param LocalizerInterface            $numberLocalizer
     * @param NormalizerInterface           $lightAttributeNormalizer
     * @param TranslatorInterface           $translator
     * @param AttributeIsAFamilyVariantAxis $attributeIsAFamilyVariantAxisQuery
     */
    public function __construct(
        AttributeRepositoryInterface $attributeRepository,
        NormalizerInterface $normalizer,
        TokenStorageInterface $tokenStorage,
        ObjectFilterInterface $attributeFilter,
        SearchableRepositoryInterface $attributeSearchRepository,
        ObjectUpdaterInterface $updater,
        ValidatorInterface $validator,
        SaverInterface $saver,
        RemoverInterface $remover,
        AttributeFactory $factory,
        UserContext $userContext,
        LocalizerInterface $numberLocalizer,
        NormalizerInterface $lightAttributeNormalizer,
        TranslatorInterface $translator,
        AttributeIsAFamilyVariantAxis $attributeIsAFamilyVariantAxisQuery
    ) {
        parent::__construct(
            $attributeRepository,
            $normalizer,
            $tokenStorage,
            $attributeFilter,
            $attributeSearchRepository,
            $updater,
            $validator,
            $saver,
            $remover,
            $factory,
            $userContext,
            $numberLocalizer,
            $lightAttributeNormalizer,
            $translator,
            $attributeIsAFamilyVariantAxisQuery
        );

        $this->translator               = $translator;
        $this->userContext              = $userContext;
        $this->lightAttributeNormalizer = $lightAttributeNormalizer;
    }

    /**
     * Description listAction function
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function listAction(Request $request): JsonResponse
    {
        /** @var AttributeInterface[] $attributes */
        $attributes = $this->attributeSearchRepository->findBySearch(
            $request->request->get('search'),
            []
        );
        /** @var mixed[] $normalizedAttributes */
        $normalizedAttributes = array_map(function ($attribute) {
            return $this->lightAttributeNormalizer->normalize(
                $attribute,
                'internal_api',
                [ 'locale' => $this->userContext->getUiLocale()->getCode() ]
            );
        }, $attributes);

        return new JsonResponse($normalizedAttributes);
    }
}

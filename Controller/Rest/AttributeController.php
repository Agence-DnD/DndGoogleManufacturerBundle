<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest;

use Akeneo\Component\Localization\Localizer\LocalizerInterface;
use Akeneo\Component\StorageUtils\Remover\RemoverInterface;
use Akeneo\Component\StorageUtils\Repository\SearchableRepositoryInterface;
use Akeneo\Component\StorageUtils\Saver\SaverInterface;
use Akeneo\Component\StorageUtils\Updater\ObjectUpdaterInterface;
use Pim\Bundle\CatalogBundle\Doctrine\ORM\Query\AttributeIsAFamilyVariantAxis;
use Pim\Bundle\CatalogBundle\Filter\ObjectFilterInterface;
use Pim\Bundle\EnrichBundle\Controller\Rest\AttributeController as PimAttributeController;
use Pim\Bundle\UserBundle\Context\UserContext;
use Pim\Component\Catalog\Factory\AttributeFactory;
use Pim\Component\Catalog\Model\AttributeInterface;
use Pim\Component\Catalog\Repository\AttributeRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AttributeController
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class AttributeController extends PimAttributeController
{
    /** @var TranslatorInterface */
    private $translator;
    /** @var UserContext $userContext */
    private $userContext;
    /** @var NormalizerInterface $lightAttributeNormalizer */
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

        $this->translator = $translator;
        $this->userContext = $userContext;
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
                ['locale' => $this->userContext->getUiLocale()->getCode()]
            );
        }, $attributes);

        return new JsonResponse($normalizedAttributes);
    }
}

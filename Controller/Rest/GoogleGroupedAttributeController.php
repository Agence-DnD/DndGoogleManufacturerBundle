<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest;

use Dnd\Bundle\GoogleManufacturerBundle\ArrayConverter\StandardToFlat\Attribute\Google;
use Dnd\Bundle\GoogleManufacturerBundle\Model\GoogleImportExport;
use Dnd\Bundle\GoogleManufacturerBundle\Validator\Constraints\FieldValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Required;

/**
 * Class GoogleGroupedAttributeController
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Controller\Rest
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2019 Agence Dn'D
 * @license   https://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class GoogleGroupedAttributeController
{
    /**
     * Description checkAction function
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function getRequirements(Request $request)
    {
        if (!$request->query->has('identifier')) {
            return new JsonResponse([]);
        }
        /** @var string|null $groupedType */
        $groupedType = $request->query->get('identifier');
        if (!$groupedType || ($groupedType !== GoogleImportExport::ATTR_PRODUCT_DETAILS && $groupedType !== GoogleImportExport::ATTR_FEATURE_DESCRIPTIONS)) {
            return new JsonResponse([]);
        }

        $gGroupedType = GoogleImportExport::GOOGLE_ATTR_PRODUCT_DETAIL;
        if ($groupedType === GoogleImportExport::ATTR_FEATURE_DESCRIPTIONS) {
            $gGroupedType = GoogleImportExport::GOOGLE_ATTR_FEATURE_DESCRIPTION;
        }
        /** @var Collection $validations */
        $validations = FieldValidator::getConstraints();
        if (!isset($validations->fields[$gGroupedType])) {
            return new JsonResponse([]);
        }
        /** @var string[] $requirements */
        $requirements = [];
        /** @var Constraint $constraints */
        $constraintFields = $validations->fields[$gGroupedType];
        /** @var Constraint $constraintField */
        foreach ($constraintFields as $index => $constraintField) {
            if ($index !== 'constraints') {
                continue;
            }
            foreach ($constraintField as $constraints) {
                if ($constraints instanceof All) {
                    $constraints = $constraints->constraints;
                    foreach ($constraints as $constraint) {
                        if (!$constraint->fields) {
                            continue;
                        }
                        /** @var mixed[] $fields */
                        $fields = $constraint->fields;
                        foreach ($fields as $attributeKey => $field) {
                            if ($field instanceof Required && isset(Google::GOOGLE_MAPPING_GROUPED_ATTRIBUTES[$attributeKey])) {
                                $requirements = array_merge($requirements, [Google::GOOGLE_MAPPING_GROUPED_ATTRIBUTES[$attributeKey]]);
                            }
                        }
                    }
                }
            }

        }

        return new JsonResponse(array_unique($requirements));
    }
}

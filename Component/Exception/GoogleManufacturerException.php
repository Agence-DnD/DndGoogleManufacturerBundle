<?php

declare(strict_types=1);

namespace Dnd\Google\Manufacturer\Bundle\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class GoogleManufacturerException
 *
 * @package   Dnd\Google\Manufacturer\Bundle\Exception
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2020 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class GoogleManufacturerException extends \Exception
{
    /**
     * Description $violations field
     *
     * @var ConstraintViolationListInterface $violations
     */
    private $violations;

    /**
     * Description missingChannel function
     *
     * @return GoogleManufacturerException
     */
    public static function missingChannel(): GoogleManufacturerException
    {
        /** @var string $message */
        $message = 'Export job profile must be filtered by a channel';

        return new static(
            sprintf($message)
        );
    }

    /**
     * Description convertException function
     *
     * @param string $reason
     *
     * @return GoogleManufacturerException
     */
    public static function convertException(string $reason): GoogleManufacturerException
    {
        /** @var string $message */
        $message = 'Product can not be convert properly. Reason: %s';

        return new static(
            sprintf($message, $reason)
        );
    }

    /**
     * Description getViolations function
     *
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ?ConstraintViolationListInterface
    {
        return $this->violations;
    }

    /**
     * Description setViolations function
     *
     * @param ConstraintViolationListInterface $violations
     *
     * @return GoogleManufacturerException
     */
    public function setViolations(ConstraintViolationListInterface $violations): GoogleManufacturerException
    {
        $this->violations = $violations;

        return $this;
    }
}

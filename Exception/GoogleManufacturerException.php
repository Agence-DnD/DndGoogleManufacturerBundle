<?php

namespace Dnd\Bundle\GoogleManufacturerBundle\Exception;

/**
 * Class GoogleManufacturerException
 *
 * @category  Class
 * @package   Dnd\Bundle\GoogleManufacturerBundle\Exception
 * @author    Agence Dn'D <contact@dnd.fr>
 * @copyright 2018 Agence Dn'D
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @link      https://www.dnd.fr/
 */
class GoogleManufacturerException extends \Exception
{
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
}

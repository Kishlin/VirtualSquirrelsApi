<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:43
 */

namespace App\Exception;


use App\CoreException;


/**
 * @package App\Exception
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class InvalidArgumentException extends \InvalidArgumentException
{

    /**
     * @param string $message
     */
    public function __construct(string $message = 'Invalid argument provided.')
    {
        parent::__construct($message, CoreException::INVALID_ARGUMENT_EXCEPTION, null);
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:43
 */

namespace CoreBundle\Exception;


use CoreBundle\CoreException;


/**
 * @package CoreBundle\Exception
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class InvalidArgumentException extends \InvalidArgumentException
{

    /**
     * @param string $message
     */
    public function __construct(string $message = '')
    {
        parent::__construct($message, CoreException::INVALID_ARGUMENT_EXCEPTION, null);
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:25
 */

namespace CoreBundle\Exception;


use CoreBundle\CoreException;

/**
 * @package CoreBundle\Exception
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RuntimeException extends \RuntimeException
{

    /**
     * @param string     $message
     * @param \Throwable $previous
     */
    public function __construct($message, \Throwable $previous)
    {
        parent::__construct($message, CoreException::RUNTIME_EXCEPTION, $previous);
    }

}
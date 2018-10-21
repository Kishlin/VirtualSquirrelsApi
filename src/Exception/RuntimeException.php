<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:25
 */

namespace App\Exception;


use App\CoreException;

/**
 * @package App\Exception
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
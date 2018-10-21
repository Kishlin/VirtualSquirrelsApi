<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 09:38
 */

namespace App\Exception;


use App\CoreException;

/**
 * @package App\Exception
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class LogicException extends \LogicException
{

    /**
     * @param string $message
     */
    public function __construct(string $message = 'Statement should not be reached.')
    {
        parent::__construct($message, CoreException::LOGIC_EXCEPTION, null);
    }

}
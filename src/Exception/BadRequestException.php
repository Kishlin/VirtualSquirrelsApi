<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 18:26
 */

namespace App\Exception;


use App\CoreException;


/**
 * @package App\Exception
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class BadRequestException extends \Exception
{

    /**
     * @param string $message
     */
    public function __construct(string $message = 'Bad request.')
    {
        parent::__construct($message, CoreException::BAD_REQUEST_EXCEPTION, null);
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:36
 */

namespace App;


/**
 * @package App
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
final class CoreException
{

    private function __construct() { }

    /** @var int */
    const RUNTIME_EXCEPTION = 666;

    /** @var int */
    const INVALID_ARGUMENT_EXCEPTION = 100;

    /** @var int */
    const BAD_REQUEST_EXCEPTION = 200;

    /** @var int */
    const LOGIC_EXCEPTION = 300;


    /** @var string */
    const MESSAGE_USER_NOT_FOUND = 'User was not found.';

}

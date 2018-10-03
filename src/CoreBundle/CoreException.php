<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:36
 */

namespace CoreBundle;


/**
 * @package CoreBundle
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
final class CoreException
{

    private function __construct() { }

    /** @var int */
    const RUNTIME_EXCEPTION = 666;

    /** @var int */
    const INVALID_ARGUMENT_EXCEPTION = 100;

}
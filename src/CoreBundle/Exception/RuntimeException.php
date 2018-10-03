<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:25
 */

namespace CoreBundle\Exception;


/**
 * @package CoreBundle\Exception
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RuntimeException extends \RuntimeException
{

    /**
     * @param \Throwable $previous
     */
    public function __construct(\Throwable $previous)
    {
        parent::__construct('', 0, $previous);
    }

}
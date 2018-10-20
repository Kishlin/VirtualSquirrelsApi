<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 17:36
 */

namespace CoreBundle\Exception;


use Symfony\Component\Security\Core\Exception\AccessDeniedException as BaseException;

/**
 * @package CoreBundle\Exception
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AccessDeniedException extends BaseException
{

    /**
     * @param string $message
     */
    public function __construct(string $message = 'Access denied.')
    {
        parent::__construct($message);
    }

}
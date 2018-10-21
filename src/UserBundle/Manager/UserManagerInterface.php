<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 14:50
 */

namespace UserBundle\Manager;


use UserBundle\Entity\User;

/**
 * @package UserBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface UserManagerInterface
{

    /**
     * @param string $role
     * @param bool   $withCurrent
     * @return User[]
     */
    function getFilteredListForRole(string $role, bool $withCurrent = true): array;

}
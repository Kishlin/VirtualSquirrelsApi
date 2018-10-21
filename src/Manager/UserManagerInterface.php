<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 14:50
 */

namespace App\Manager;


use App\Entity\User;

/**
 * @package App\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface UserManagerInterface
{

    /**
     * @param User   $user
     * @param string $role
     * @return User
     */
    function promote(User $user, string $role): User;

    /**
     * @param User   $user
     * @param string $role
     * @return User
     */
    function demote(User $user, string $role): User;

    /**
     * @param string $role
     * @param bool   $withCurrent
     * @return User[]
     */
    function getFilteredListForRole(string $role, bool $withCurrent = true): array;

}
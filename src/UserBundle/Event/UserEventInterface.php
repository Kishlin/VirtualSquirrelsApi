<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:57
 */

namespace UserBundle\Event;


use UserBundle\Entity\User;

/**
 * @package UserBundle\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface UserEventInterface
{

    /**
     * @return User
     */
    function getUser(): User;

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:07
 */

namespace CoreBundle\Manager\Event;


use CoreBundle\Entity\Event\Event;
use UserBundle\Entity\User;
use UserBundle\UserRoles;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface EventParticipationManagerInterface
{

    /**
     * @param Event $event
     * @param User  $user
     * @param int   $type
     * @return Event
     */
    function addParticipationForType(Event $event, User $user, int $type): Event;

}
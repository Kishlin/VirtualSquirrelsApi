<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:07
 */

namespace CoreBundle\Manager\Event;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Entity\Event\EventParticipation;
use UserBundle\Entity\User;

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
     * @return EventParticipation
     */
    function addParticipationForType(Event $event, User $user, int $type): EventParticipation;

    /**
     * @param Event $event
     * @param User  $user
     */
    function removeIfExists(Event $event, User $user): void;

}
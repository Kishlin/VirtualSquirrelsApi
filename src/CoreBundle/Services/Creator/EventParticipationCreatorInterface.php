<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 15:09
 */

namespace CoreBundle\Services\Creator;


use CoreBundle\Entity\Event;
use CoreBundle\Entity\EventParticipation;
use UserBundle\Entity\User;


/**
 * @package CoreBundle\Services\Creator
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface EventParticipationCreatorInterface
{

    /**
     * @param Event $event
     * @param User  $user
     * @param int   $type
     * @return EventParticipation
     */
    function createForType(Event $event, User $user, int $type): EventParticipation;

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 15:09
 */

namespace App\Services\Event;


use App\Entity\Event\Event;
use App\Entity\Event\EventParticipation;
use App\Entity\User;

/**
 * @package App\Services\Creator
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

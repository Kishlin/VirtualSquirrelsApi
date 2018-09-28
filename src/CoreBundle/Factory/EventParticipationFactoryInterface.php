<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:04
 */

namespace CoreBundle\Factory;


use CoreBundle\Entity\Event;
use CoreBundle\Entity\EventParticipation;
use CoreBundle\Entity\EventParticipationType;
use UserBundle\Entity\User;


/**
 * @package CoreBundle\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface EventParticipationFactoryInterface
{

    /**
     * @param Event                  $event
     * @param EventParticipationType $type
     * @param User                   $participant
     * @return EventParticipation
     */
    function newEventParticipation(Event $event, EventParticipationType $type, User $participant): EventParticipation;

}
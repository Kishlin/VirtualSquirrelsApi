<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:04
 */

namespace App\Factory\Event;


use App\Entity\Event\Event;
use App\Entity\Event\EventParticipation;
use App\Entity\Event\EventParticipationType;
use App\Entity\User;

/**
 * @package App\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationFactory implements EventParticipationFactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function newEventParticipation(Event $event, EventParticipationType $type, User $participant): EventParticipation
    {
        return (new EventParticipation())
            ->setEvent($event)
            ->setEventParticipationType($type)
            ->setParticipant($participant)
        ;
    }

}

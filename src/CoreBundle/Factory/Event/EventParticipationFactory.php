<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:04
 */

namespace CoreBundle\Factory\Event;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Entity\Event\EventParticipation;
use CoreBundle\Entity\Event\EventParticipationType;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Factory
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

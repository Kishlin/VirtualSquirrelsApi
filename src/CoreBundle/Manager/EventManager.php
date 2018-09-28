<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 14:49
 */

namespace CoreBundle\Manager;


use CoreBundle\CoreEvents;
use CoreBundle\Entity\Event;
use CoreBundle\Entity\EventParticipation;
use CoreBundle\Enumerations\EventParticipationType;
use CoreBundle\Services\Creator\EventParticipationCreatorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use UserBundle\Entity\User;


/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventManager implements EventManagerInterface
{

    /** @var EventParticipationCreatorInterface */
    protected $creator;

    /** @var EventDispatcherInterface */
    protected $dispatcher;

    /** @var ObjectManager */
    protected $objectManager;

    /**
     * {@inheritdoc}
     */
    public function addPositiveParticipation(Event $event, User $user): Event
    {
        return $this->addParticipation($this->creator->createForType($event, $user, EventParticipationType::TYPE_POSITIVE));
    }

    /**
     * {@inheritdoc}
     */
    public function addNegativeParticipation(Event $event, User $user): Event
    {
        return $this->addParticipation($this->creator->createForType($event, $user, EventParticipationType::TYPE_NEGATIVE));
    }

    /**
     * {@inheritdoc}
     */
    public function addUnsureParticipation(Event $event, User $user): Event
    {
        return $this->addParticipation($this->creator->createForType($event, $user, EventParticipationType::TYPE_UNSURE));
    }

    /**
     * @param EventParticipation $eventParticipation
     * @return Event
     */
    private function addParticipation(EventParticipation $eventParticipation): Event
    {
        // TODO Trigger event to remove current participations.

        $event = $kernelEvent->getEvent();
        $this->objectManager->persist($eventParticipation);
        if (!$this->objectManager->contains($event)) $this->objectManager->persist($event);

        $this->objectManager->flush();

        return $event;
    }

}
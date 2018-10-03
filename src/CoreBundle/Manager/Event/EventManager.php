<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 14:49
 */

namespace CoreBundle\Manager\Event;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Entity\Event\EventParticipation;
use CoreBundle\Enum\EventParticipationTypeEnum;
use CoreBundle\Services\Event\EventParticipationCreatorInterface;
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
        return $this->addParticipation($this->creator->createForType($event, $user, EventParticipationTypeEnum::TYPE_POSITIVE));
    }

    /**
     * {@inheritdoc}
     */
    public function addNegativeParticipation(Event $event, User $user): Event
    {
        return $this->addParticipation($this->creator->createForType($event, $user, EventParticipationTypeEnum::TYPE_NEGATIVE));
    }

    /**
     * {@inheritdoc}
     */
    public function addUnsureParticipation(Event $event, User $user): Event
    {
        return $this->addParticipation($this->creator->createForType($event, $user, EventParticipationTypeEnum::TYPE_UNSURE));
    }

    /**
     * {@inheritdoc}
     */
    public function addBackupParticipation(Event $event, User $user): Event
    {
        return $this->addParticipation($this->creator->createForType($event, $user, EventParticipationTypeEnum::TYPE_BACKUP));
    }

    /**
     * @param EventParticipation $eventParticipation
     * @return Event
     */
    private function addParticipation(EventParticipation $eventParticipation): Event
    {
        $event = $eventParticipation->getEvent();

        $this->objectManager->persist($eventParticipation);
        if (!$this->objectManager->contains($event)) $this->objectManager->persist($event);

        $this->objectManager->flush();

        return $event;
    }

}
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
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationManager implements EventParticipationManagerInterface
{

    /** @var EventParticipationCreatorInterface */
    protected $creator;

    /** @var ObjectManager */
    protected $objectManager;


    /**
     * {@inheritdoc}
     */
    public function addParticipationForType(Event $event, User $user, int $type): Event
    {
        $eventParticipation = $this->creator->createForType($event, $user, $type);

        $this->objectManager->persist($eventParticipation);
        if (!$this->objectManager->contains($event)) $this->objectManager->persist($event);

        $this->objectManager->flush();

        return $event;
    }

}
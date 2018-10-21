<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 14:49
 */

namespace CoreBundle\Manager\Event;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Services\Event\EventParticipationCreatorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CoreBundle\Entity\Event\EventParticipation;
use Psr\Log\LoggerInterface;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationManager implements EventParticipationManagerInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var EventParticipationCreatorInterface */
    protected $creator;

    /** @var ObjectManager */
    protected $objectManager;

    /**
     * @param LoggerInterface                    $logger
     * @param EventParticipationCreatorInterface $creator
     * @param ObjectManager                      $objectManager
     */
    public function __construct(LoggerInterface $logger, EventParticipationCreatorInterface $creator, ObjectManager $objectManager)
    {
        $this->logger        = $logger;
        $this->creator       = $creator;
        $this->objectManager = $objectManager;
    }


    /**
     * {@inheritdoc}
     */
    public function addParticipationForType(Event $event, User $user, int $type): EventParticipation
    {
        $eventParticipation = $this->creator->createForType($event, $user, $type);
        $event->addEventParticipationList($eventParticipation);

        $this->logger->debug('Saving up new participation.', array(
            'type'   => $type,
            'event'  => $event->getId(),
            'user'   => $user->getId(),
            'method' => 'addParticipationForType',
            'class'  => self::class
        ));

        $this->objectManager->contains($event) || $this->objectManager->persist($event);
        $this->objectManager->persist($eventParticipation);

        $this->objectManager->flush();

        return $eventParticipation;
    }

    /**
     * {@inheritdoc}
     */
    public function removeIfExists(Event $event, User $user): void
    {
        $criteria = array('event' => $event, 'participant' => $user);

        /** @var EventParticipation $eventParticipation */
        $eventParticipation = $this->objectManager->getRepository(EventParticipation::REPOSITORY)->findOneBy($criteria);

        if (null !== $eventParticipation) {
            $this->logger->debug('A participation was found. Removing.', array(
                'participation' => $eventParticipation->getId(),
                'event'         => $event->getId(),
                'user'          => $user->getId(),
                'method'        => 'removeIfExists',
                'class'         => self::class
            ));

            $this->objectManager->remove($eventParticipation);

            $this->objectManager->flush();
        }
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 15:10
 */

namespace CoreBundle\Services\Event;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Entity\Event\EventParticipation;
use CoreBundle\Factory\Event\EventParticipationFactoryInterface;
use CoreBundle\Manager\Event\EventParticipationTypeManagerInterface;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Services\Creator
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationCreator implements EventParticipationCreatorInterface
{

    /** @var EventParticipationFactoryInterface */
    protected $factory;

    /** @var EventParticipationTypeManagerInterface */
    protected $typeManager;

    /**
     * @param EventParticipationFactoryInterface     $factory
     * @param EventParticipationTypeManagerInterface $typeManager
     */
    public function __construct(EventParticipationFactoryInterface $factory, EventParticipationTypeManagerInterface $typeManager)
    {
        $this->factory = $factory;
        $this->typeManager = $typeManager;
    }


    /**
     * {@inheritdoc}
     */
    public function createForType(Event $event, User $user, int $type): EventParticipation
    {
        $type = $this->typeManager->getByType($type);

        return $this->factory->newEventParticipation($event, $type, $user);
    }

}

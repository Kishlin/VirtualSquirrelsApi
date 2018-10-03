<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 15:10
 */

namespace CoreBundle\Services\Event;


use CoreBundle\Entity\Event;
use CoreBundle\Entity\EventParticipation;
use CoreBundle\Factory\EventParticipationFactoryInterface;
use CoreBundle\Manager\EventParticipationTypeManagerInterface;
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

        // TODO Type can be null if not found.

        return $this->factory->newEventParticipation($event, $type, $user);
    }

}
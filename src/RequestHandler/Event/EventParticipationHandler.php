<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 12:12 PM
 */

namespace App\RequestHandler\Event;


use App\CoreEvents;
use App\Entity\Event\Event;
use App\Event\Event\AddParticipationInitializeEvent;
use App\Event\Event\EventFinalizeEvent;
use App\Event\Event\RemoveParticipationInitializeEvent;
use App\Manager\Event\EventParticipationManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

/**
 * @package App\RequestHandler\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class EventParticipationHandler implements EventParticipationHandlerInterface
{

    /** @var EventParticipationManagerInterface */
    protected $eventParticipationManager;

    /** @var EventDispatcherInterface */
    protected $dispatcher;

    /**
     * @param EventParticipationManagerInterface $eventParticipationManager
     * @param EventDispatcherInterface           $dispatcher
     */
    public function __construct(EventParticipationManagerInterface $eventParticipationManager, EventDispatcherInterface $dispatcher)
    {
        $this->eventParticipationManager = $eventParticipationManager;
        $this->dispatcher = $dispatcher;
    }


    /**
     * {@inheritdoc}
     */
    public function add(Event $event, User $user, int $type): Response
    {
        $initializeEvent = new AddParticipationInitializeEvent($user, $event, $type);
        $this->dispatcher->dispatch(CoreEvents::EVENT_ADD_PARTICIPATION_INITIALIZE, $initializeEvent);

        $this->eventParticipationManager->addParticipationForType($event, $user, $type);

        $finalizeEvent = new EventFinalizeEvent($user, $event);
        $this->dispatcher->dispatch(CoreEvents::EVENT_FINALIZE_EVENT, $finalizeEvent);

        if (null !== $response = $finalizeEvent->getResponse())
            return $response;

        return new Response();
    }

    /**
     * {@inheritdoc}
     */
    public function remove(Event $event, User $user): Response
    {
        $initializeEvent = new RemoveParticipationInitializeEvent($user, $event);
        $this->dispatcher->dispatch(CoreEvents::EVENT_REMOVE_PARTICIPATION_INITIALIZE, $initializeEvent);

        $this->eventParticipationManager->removeIfExists($event, $user);

        $finalizeEvent = new EventFinalizeEvent($user, $event);
        $this->dispatcher->dispatch(CoreEvents::EVENT_FINALIZE_EVENT, $finalizeEvent);

        if (null !== $response = $finalizeEvent->getResponse())
            return $response;

        return new Response();
    }

}

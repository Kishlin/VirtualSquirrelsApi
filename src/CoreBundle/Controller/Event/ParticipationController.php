<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 17:46
 */

namespace CoreBundle\Controller\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Entity\Event\Event;
use CoreBundle\Event\Event\AddParticipationFinalizeEvent;
use CoreBundle\Event\Event\AddParticipationInitializeEvent;
use CoreBundle\Event\Event\EventFinalizeEvent;
use CoreBundle\Event\Event\RemoveParticipationFinalizeEvent;
use CoreBundle\Event\Event\RemoveParticipationInitializeEvent;
use CoreBundle\Manager\Event\EventParticipationManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * @package CoreBundle\Controller\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class ParticipationController extends FOSRestController
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
     * @ParamConverter("event", options={"mapping"={"eventId"="id"}})
     *
     * @param Event $event
     * @param int   $type
     * @return Response
     */
    public function addAction(Event $event, int $type): Response
    {
        $user = $this->getUser();

        $initializeEvent = new AddParticipationInitializeEvent($user, $event, $type);
        $this->dispatcher->dispatch(CoreEvents::EVENT_ADD_PARTICIPATION_INITIALIZE, $initializeEvent);

        $this->eventParticipationManager->addParticipationForType($event, $user, $type);

        $finalizeEvent = new EventFinalizeEvent($event, $user);
        $this->dispatcher->dispatch(CoreEvents::EVENT_FINALIZE_EVENT, $finalizeEvent);

        if (null !== $response = $finalizeEvent->getResponse())
            return $response;

        return new Response();
    }

    /**
     * @ParamConverter("event", options={"mapping"={"eventId"="id"}})
     *
     * @param Event $event
     * @return Response
     */
    public function removeAction(Event $event): Response
    {
        $user = $this->getUser();

        $initializeEvent = new RemoveParticipationInitializeEvent($user, $event);
        $this->dispatcher->dispatch(CoreEvents::EVENT_REMOVE_PARTICIPATION_INITIALIZE, $initializeEvent);

        $this->eventParticipationManager->removeIfExists($event, $user);

//        $finalizeEvent = new ParticipationFinalizeEvent($user, $event);
//        $this->dispatcher->dispatch(CoreEvents::EVENT_REMOVE_PARTICIPATION_FINALIZE, $finalizeEvent);
//
//        if (null !== $response = $finalizeEvent->getResponse())
//            return $response;

        return new Response();
    }

}

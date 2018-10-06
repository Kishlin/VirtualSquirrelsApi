<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:33 AM
 */

namespace CoreBundle\Controller\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Entity\Event\Event;
use CoreBundle\Event\Event\AddParticipationInitializeEvent;
use CoreBundle\Event\Event\EventFinalizeEvent;
use CoreBundle\Event\Event\ForceParticipationEvent;
use CoreBundle\Event\Event\RemoveParticipationInitializeEvent;
use CoreBundle\Manager\Event\EventParticipationManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @package CoreBundle\Controller\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class ForceParticipationController extends Controller
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
     * @ParamConverter("user",  options={"mapping"={"userId"="id"}})
     *
     * @param Event $event
     * @param User  $user
     * @param int   $type
     * @return Response
     */
    public function addAction(Event $event, User $user, int $type): Response
    {
        $userEvent = new ForceParticipationEvent($this->getUser(), $event);
        $this->dispatcher->dispatch(CoreEvents::EVENT_FORCE_PARTICIPATION, $userEvent);

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
     * @ParamConverter("event", options={"mapping"={"eventId"="id"}})
     * @ParamConverter("user",  options={"mapping"={"userId"="id"}})
     *
     * @param Event $event
     * @param User  $user
     * @return Response
     */
    public function removeAction(Event $event, User $user): Response
    {
        $userEvent = new ForceParticipationEvent($this->getUser(), $event);
        $this->dispatcher->dispatch(CoreEvents::EVENT_FORCE_PARTICIPATION, $userEvent);

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

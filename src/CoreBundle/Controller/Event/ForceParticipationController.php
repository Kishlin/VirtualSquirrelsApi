<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:33 AM
 */

namespace CoreBundle\Controller\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Entity\Event\Event;
use CoreBundle\Event\Event\ForceParticipationEvent;
use CoreBundle\RequestHandler\Event\EventParticipationHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Controller\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class ForceParticipationController extends Controller
{

    /** @var EventDispatcherInterface */
    protected $dispatcher;

    /** @var EventParticipationHandlerInterface */
    protected $eventParticipationHandler;

    /**
     * @param EventDispatcherInterface           $dispatcher
     * @param EventParticipationHandlerInterface $eventParticipationHandler
     */
    public function __construct(EventDispatcherInterface $dispatcher, EventParticipationHandlerInterface $eventParticipationHandler)
    {
        $this->dispatcher                = $dispatcher;
        $this->eventParticipationHandler = $eventParticipationHandler;
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

        return $this->eventParticipationHandler->add($event, $user, $type);
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

        return $this->eventParticipationHandler->remove($event, $user);
    }

}

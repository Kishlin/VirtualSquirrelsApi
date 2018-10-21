<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:33 AM
 */

namespace App\Controller\Event;


use App\RequestHandler\Event\EventParticipationHandlerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Event\Event\ForceParticipationEvent;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Event\Event;
use App\Entity\User;
use App\CoreEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @package App\Controller\Event
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
        $userEvent = new ForceParticipationEvent($this->getUser(), $user, $event);
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
        $userEvent = new ForceParticipationEvent($this->getUser(), $user, $event);
        $this->dispatcher->dispatch(CoreEvents::EVENT_FORCE_PARTICIPATION, $userEvent);

        return $this->eventParticipationHandler->remove($event, $user);
    }

}

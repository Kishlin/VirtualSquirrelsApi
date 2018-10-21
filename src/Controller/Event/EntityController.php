<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 2:37 PM
 */

namespace App\Controller\Event;


use App\CoreEvents;
use App\Entity\Event\Event;
use App\Event\Event\EntityEvent;
use App\Event\Event\EventFinalizeEvent;
use App\Manager\Event\EntityManagerInterface;
use App\RequestHandler\Event\EntityHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package App\Controller\Event
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link https://pierrelouislegrand.fr
 */
class EntityController extends Controller
{

    /** @var EntityHandlerInterface */
    protected $entityHandler;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @param EntityHandlerInterface $formHandler
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityHandlerInterface $formHandler, EventDispatcherInterface $eventDispatcher)
    {
        $this->entityHandler   = $formHandler;
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws \App\Exception\BadRequestException
     */
    public function createAction(Request $request): Response
    {
        $requestingUser = $this->getUser();

        return $this->entityHandler->handleEventForm($request, $requestingUser, null);
    }

    /**
     * @param Request $request
     * @param Event $event
     * @return Response
     * @throws \App\Exception\BadRequestException
     */
    public function editAction(Request $request, Event $event): Response
    {
        $requestingUser = $this->getUser();

        $entityEvent = new EntityEvent($requestingUser, $event);
        $this->eventDispatcher->dispatch(CoreEvents::EVENT_ENTITY_INITIALIZE, $entityEvent);

        return $this->entityHandler->handleEventForm($request, $requestingUser, $event);
    }

    /**
     * @param EntityManagerInterface $eventManager
     * @param Event $event
     * @return Response
     */
    public function removeAction(EntityManagerInterface $eventManager, Event $event): Response
    {
        $requestingUser = $this->getUser();

        $entityEvent = new EntityEvent($requestingUser, $event);
        $this->eventDispatcher->dispatch(CoreEvents::EVENT_ENTITY_INITIALIZE, $entityEvent);

        $event = $eventManager->removeEvent($event);

        $finalizeEvent = new EventFinalizeEvent($requestingUser, $event);
        $this->eventDispatcher->dispatch(CoreEvents::EVENT_FINALIZE_EVENT, $finalizeEvent);

        return $finalizeEvent->getResponse() ?? new Response();
    }

}

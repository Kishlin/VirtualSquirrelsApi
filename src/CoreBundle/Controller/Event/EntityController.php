<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 2:37 PM
 */

namespace CoreBundle\Controller\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Entity\Event\Event;
use CoreBundle\Event\Event\EntityEvent;
use CoreBundle\Event\Event\EventFinalizeEvent;
use CoreBundle\Manager\Event\EntityManagerInterface;
use CoreBundle\RequestHandler\Event\EntityHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package CoreBundle\Controller\Event
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
     * @throws \CoreBundle\Exception\BadRequestException
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
     * @throws \CoreBundle\Exception\BadRequestException
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

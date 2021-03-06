<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 17:46
 */

namespace App\Controller\Event;


use App\RequestHandler\Event\EventParticipationHandlerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Event\Event;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @package App\Controller\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class ParticipationController extends Controller
{

    /** @var EventParticipationHandlerInterface */
    protected $eventParticipationHandler;

    /**
     * @param EventParticipationHandlerInterface $eventParticipationHandler
     */
    public function __construct(EventParticipationHandlerInterface $eventParticipationHandler)
    {
        $this->eventParticipationHandler = $eventParticipationHandler;
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

        return $this->eventParticipationHandler->add($event, $user, $type);
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

        return $this->eventParticipationHandler->remove($event, $user);
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 18:00
 */

namespace CoreBundle\Event\Event;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Entity\Event\EventParticipation;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package CoreBundle\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AddParticipationFinalizeEvent extends \Symfony\Component\EventDispatcher\Event implements HasResponseInterface
{

    /** @var EventParticipation */
    protected $eventParticipation;

    /** @var Response */
    protected $response;

    /**
     * @param EventParticipation $eventParticipation
     */
    public function __construct(EventParticipation $eventParticipation)
    {
        $this->eventParticipation = $eventParticipation;
    }


    /**
     * @return EventParticipation
     */
    public function getEventParticipation(): EventParticipation
    {
        return $this->eventParticipation;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent(): Event
    {
        return $this->eventParticipation->getEvent();
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

}

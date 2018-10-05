<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 19:05
 */

namespace CoreBundle\Event\Event;


use CoreBundle\Entity\Event\Event;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Event\UserEventInterface;

/**
 * @package CoreBundle\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventFinalizeEvent extends \Symfony\Component\EventDispatcher\Event implements HasResponseInterface, UserEventInterface
{

    /** @var Event */
    protected $event;

    /** @var User */
    protected $user;

    /** @var Response */
    protected $response;

    /**
     * @param Event $event
     * @param User  $user
     */
    public function __construct(Event $event, User $user)
    {
        $this->event = $event;
        $this->user  = $user;
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

    /**
     * @return Event
     */
    function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @return User
     */
    function getUser(): User
    {
        return $this->user;
    }

}
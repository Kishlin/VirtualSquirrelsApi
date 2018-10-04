<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 18:05
 */

namespace CoreBundle\Event\Event;


use CoreBundle\Entity\Event\Event;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RemoveParticipationInitializeEvent extends \Symfony\Component\EventDispatcher\Event
{

    /** @var User */
    protected $user;

    /** @var Event */
    protected $event;

    /**
     * @param User  $user
     * @param Event $event
     */
    public function __construct(User $user, Event $event)
    {
        $this->user = $user;
        $this->event = $event;
    }


    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

}

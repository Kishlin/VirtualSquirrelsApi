<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:41 AM
 */

namespace App\Event\Event;


use Symfony\Component\EventDispatcher\Event AS DispatcherEvent;
use App\Entity\Event\Event;
use App\Entity\User;

/**
 * @package App\Event\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
abstract class BaseUserEvent extends DispatcherEvent implements HasUserAndEventInterface
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
        $this->event = $event;
        $this->user  = $user;
    }


    /**
     * {@inheritdoc}
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

}

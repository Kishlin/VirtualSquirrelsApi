<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:16
 */

namespace CoreBundle\Event\Notification;


use CoreBundle\Entity\Notification;
use Symfony\Component\EventDispatcher\Event;
use UserBundle\Entity\User;


/**
 * @package CoreBundle\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NewNotificationEvent extends Event
{

    /** @var User[] */
    protected $userList;

    /** @var Notification */
    protected $notification;

    /**
     * @param User[]       $userList
     * @param Notification $notification
     */
    public function __construct(array $userList, Notification $notification)
    {
        $this->userList     = $userList;
        $this->notification = $notification;
    }


    /**
     * @return User[]
     */
    public function getUserList(): array
    {
        return $this->userList;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

}
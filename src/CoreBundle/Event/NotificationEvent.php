<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 11:27
 */

namespace CoreBundle\Event;


use Mgilet\NotificationBundle\Model\Notification;
use UserBundle\Entity\User;


/**
 * @package CoreBundle\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationEvent
{

    /** @var User */
    protected $user;

    /** @var Notification */
    protected $notification;

    /**
     * @param User         $user
     * @param Notification $notification
     */
    public function __construct(User $user, Notification $notification)
    {
        $this->user = $user;
        $this->notification = $notification;
    }


    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

}
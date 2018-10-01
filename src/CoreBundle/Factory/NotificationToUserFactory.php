<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:08
 */

namespace CoreBundle\Factory;


use CoreBundle\Entity\Notification;
use CoreBundle\Entity\NotificationToUser;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationToUserFactory implements NotificationToUserFactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function new(Notification $notification, User $user): NotificationToUser
    {
        return (new NotificationToUser())
            ->setNotification($notification)
            ->setUser($user)
            ->setSeen(false)
        ;
    }

}
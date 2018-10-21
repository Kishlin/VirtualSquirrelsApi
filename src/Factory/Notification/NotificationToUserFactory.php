<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:08
 */

namespace App\Factory\Notification;


use App\Entity\Notification\Notification;
use App\Entity\Notification\NotificationToUser;
use App\Entity\User;

/**
 * @package App\Factory
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
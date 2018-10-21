<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:09
 */

namespace App\Factory\Notification;


use App\Entity\Notification\Notification;
use App\Entity\Notification\NotificationToUser;
use App\Entity\User;

/**
 * @package App\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationToUserFactoryInterface
{

    /**
     * @param Notification $notification
     * @param User         $user
     * @return NotificationToUser
     */
    function new(Notification $notification, User $user): NotificationToUser;

}
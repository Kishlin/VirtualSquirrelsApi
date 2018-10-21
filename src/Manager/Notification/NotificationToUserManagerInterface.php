<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:02
 */

namespace App\Manager\Notification;


use App\Entity\Notification\NotificationToUser;

/**
 * @package App\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationToUserManagerInterface
{

    /**
     * @param NotificationToUser $notificationToUser
     * @param bool               $flush
     */
    function save(NotificationToUser $notificationToUser, bool $flush = true): void;

}
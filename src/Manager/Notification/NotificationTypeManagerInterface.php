<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 11:58
 */

namespace App\Manager\Notification;


use App\Entity\Notification\NotificationType;


/**
 * @package App\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationTypeManagerInterface
{

    /**
     * @param string $type
     * @return NotificationType
     */
    function getByType(string $type): NotificationType;

    /**
     * @param NotificationType $notificationType
     */
    function save(NotificationType $notificationType): void;

}
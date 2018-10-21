<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:09
 */

namespace App\Factory\Notification;


use App\Entity\Notification\Notification;
use App\Entity\Notification\NotificationType;
use App\Model\NotificationTarget;

/**
 * @package App\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationFactoryInterface
{

    /**
     * @param NotificationType        $notificationType
     * @param NotificationTarget|null $target
     * @param \DateTime               $dateTime
     * @param string                  $subject
     * @param string                  $message
     * @return Notification
     */
    function new(NotificationType $notificationType,
                 ?NotificationTarget $target,
                 \DateTime $dateTime,
                 string $subject,
                 string $message): Notification;

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:09
 */

namespace CoreBundle\Factory\Notification;


use CoreBundle\Entity\Notification;
use CoreBundle\Entity\NotificationType;
use CoreBundle\Model\NotificationTarget;

/**
 * @package CoreBundle\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationFactoryInterface
{

    /**
     * @param NotificationType        $notificationType
     * @param \DateTime               $dateTime
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     * @return Notification
     */
    function new(NotificationType $notificationType,
                 \DateTime $dateTime,
                 string $subject,
                 string $message,
                 NotificationTarget $target = null): Notification;

}
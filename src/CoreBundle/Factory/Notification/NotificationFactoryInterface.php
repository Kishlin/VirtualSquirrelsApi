<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:09
 */

namespace CoreBundle\Factory\Notification;


use CoreBundle\Entity\Notification\Notification;
use CoreBundle\Entity\Notification\NotificationType;
use CoreBundle\Model\NotificationTarget;

/**
 * @package CoreBundle\Factory
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
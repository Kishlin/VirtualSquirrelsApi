<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:09
 */

namespace CoreBundle\Factory;


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
     * @param NotificationTarget $target
     * @param NotificationType   $notificationType
     * @param \DateTime          $dateTime
     * @param string             $subject
     * @param string             $message
     * @return Notification
     */
    function new(NotificationTarget $target, NotificationType $notificationType, \DateTime $dateTime, string $subject, string $message): Notification;

}
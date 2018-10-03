<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:08
 */

namespace CoreBundle\Factory;


use CoreBundle\Entity\Notification;
use CoreBundle\Entity\NotificationType;
use CoreBundle\Model\NotificationTarget;

/**
 * @package CoreBundle\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationFactory implements NotificationFactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function new(NotificationTarget $target,
                        NotificationType $notificationType,
                        \DateTime $dateTime,
                        string $subject,
                        string $message): Notification
    {
        return (new Notification())
            ->setTargetId($target->getId())
            ->setNotificationType($notificationType)
            ->setDate($dateTime)
            ->setSubject($subject)
            ->setMessage($message)
        ;
    }

}
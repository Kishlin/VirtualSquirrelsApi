<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:08
 */

namespace App\Factory\Notification;


use App\Entity\Notification\Notification;
use App\Entity\Notification\NotificationType;
use App\Model\NotificationTarget;

/**
 * @package App\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationFactory implements NotificationFactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function new(NotificationType $notificationType,
                        ?NotificationTarget $target,
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
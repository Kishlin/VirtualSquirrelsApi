<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:20
 */

namespace CoreBundle\Factory\Notification;


use CoreBundle\Entity\NotificationType;

/**
 * @package CoreBundle\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationTypeFactory implements NotificationTypeFactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function new(string $type): NotificationType
    {
        return (new NotificationType())
            ->setLabel($type)
        ;
    }

}
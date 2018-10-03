<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 11:58
 */

namespace CoreBundle\Manager\Notification;


use CoreBundle\Entity\Notification\NotificationType;


/**
 * @package CoreBundle\Manager
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
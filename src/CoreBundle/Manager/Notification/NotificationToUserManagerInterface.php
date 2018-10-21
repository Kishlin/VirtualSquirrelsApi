<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:02
 */

namespace CoreBundle\Manager\Notification;


use CoreBundle\Entity\Notification\NotificationToUser;

/**
 * @package CoreBundle\Manager
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
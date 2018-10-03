<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:07
 */

namespace CoreBundle\Manager\Notification;


use CoreBundle\Entity\Notification;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationManagerInterface
{

    /**
     * @param Notification $notification
     * @param bool         $flush
     */
    function save(Notification $notification, bool $flush = true): void;

}
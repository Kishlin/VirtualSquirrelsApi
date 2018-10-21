<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:07
 */

namespace App\Manager\Notification;


use App\Entity\Notification\Notification;

/**
 * @package App\Manager
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
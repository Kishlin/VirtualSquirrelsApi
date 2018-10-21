<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:20
 */

namespace App\Factory\Notification;


use App\Entity\Notification\NotificationType;

/**
 * @package App\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationTypeFactoryInterface
{

    /**
     * @param string $type
     * @return NotificationType
     */
    function new(string $type): NotificationType;

}
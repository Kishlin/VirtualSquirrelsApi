<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 18:09
 */

namespace CoreBundle\Factory\Notification;


use CoreBundle\Entity\Notification;
use CoreBundle\Entity\NotificationToUser;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationToUserFactoryInterface
{

    /**
     * @param Notification $notification
     * @param User         $user
     * @return NotificationToUser
     */
    function new(Notification $notification, User $user): NotificationToUser;

}
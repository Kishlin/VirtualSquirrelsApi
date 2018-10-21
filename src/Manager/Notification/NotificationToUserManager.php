<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:02
 */

namespace App\Manager\Notification;


use App\Manager\BaseManager;
use App\Entity\Notification\NotificationToUser;

/**
 * @package App\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationToUserManager extends BaseManager implements NotificationToUserManagerInterface
{

    /**
     * {@inheritdoc}
     */
    public function save(NotificationToUser $notificationToUser, bool $flush = true): void
    {
        $this->objectManager->persist($notificationToUser);

        $flush && $this->doFlush();
    }

}
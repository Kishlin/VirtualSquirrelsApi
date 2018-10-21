<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:07
 */

namespace App\Manager\Notification;


use App\Manager\BaseManager;
use App\Entity\Notification\Notification;

/**
 * @package App\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationManager extends BaseManager implements NotificationManagerInterface
{

    /**
     * {@inheritdoc}
     */
    public function save(Notification $notification, bool $flush = true): void
    {
        $this->objectManager->persist($notification);

        $flush && $this->doFlush();
    }

}
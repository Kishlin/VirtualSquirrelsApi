<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:07
 */

namespace CoreBundle\Manager\Notification;


use CoreBundle\Manager\BaseManager;
use CoreBundle\Entity\Notification;

/**
 * @package CoreBundle\Manager
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
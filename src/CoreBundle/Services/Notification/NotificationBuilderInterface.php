<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:39
 */

namespace CoreBundle\Services\Notification;


use CoreBundle\Entity\Notification\Notification;
use CoreBundle\Model\NotificationTarget;


/**
 * @package CoreBundle\Services\Notification
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationBuilderInterface
{

    /**
     * @param NotificationTarget|null $target
     * @param string                  $type
     * @param \DateTime               $dateTime
     * @param string                  $subject
     * @param string                  $message
     * @return Notification
     */
    function build(?NotificationTarget $target,
                   string $type,
                   \DateTime $dateTime,
                   string $subject,
                   string $message): Notification;

}
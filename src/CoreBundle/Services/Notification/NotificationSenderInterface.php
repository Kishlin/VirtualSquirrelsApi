<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:59
 */

namespace CoreBundle\Services\Notification;


use CoreBundle\Model\NotificationTarget;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Services\Notification
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface NotificationSenderInterface
{

    /**
     * @param string                  $type
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     */
    function sendNotificationToTrials(string $type, string $subject, string $message, ?NotificationTarget $target): void;

    /**
     * @param string                  $type
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     */
    function sendNotificationToMembers(string $type, string $subject, string $message, ?NotificationTarget $target): void;

    /**
     * @param string                  $type
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     */
    function sendNotificationToOfficers(string $type, string $subject, string $message, ?NotificationTarget $target): void;

    /**
     * @param User[]                  $userList
     * @param string                  $type
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     */
    function sendNotificationToUserList(array $userList,
                                        string $type,
                                        string $subject,
                                        string $message,
                                        ?NotificationTarget $target): void;

    /**
     * @param User                    $user
     * @param string                  $type
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     */
    function sendNotificationToUser(User $user, string $type, string $subject, string $message, ?NotificationTarget $target): void;

}

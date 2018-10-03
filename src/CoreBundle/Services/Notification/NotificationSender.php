<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:59
 */

namespace CoreBundle\Services\Notification;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use CoreBundle\Event\Notification\NewNotificationEvent;
use CoreBundle\Entity\Notification\Notification;
use UserBundle\Manager\UserManagerInterface;
use CoreBundle\Model\NotificationTarget;
use Psr\Log\LoggerInterface;
use UserBundle\Entity\User;
use CoreBundle\CoreEvents;
use UserBundle\UserRoles;

/**
 * @package CoreBundle\Services\Notification
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationSender implements NotificationSenderInterface
{

    /** @var NotificationBuilderInterface */
    protected $notificationBuilder;

    /** @var UserManagerInterface */
    protected $userManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param NotificationBuilderInterface $notificationBuilder
     * @param EventDispatcherInterface     $eventDispatcher
     * @param UserManagerInterface         $userManager
     * @param LoggerInterface              $logger
     */
    public function __construct(NotificationBuilderInterface $notificationBuilder,
                                EventDispatcherInterface $eventDispatcher,
                                UserManagerInterface $userManager,
                                LoggerInterface $logger)
    {
        $this->notificationBuilder = $notificationBuilder;
        $this->eventDispatcher     = $eventDispatcher;
        $this->userManager         = $userManager;
        $this->logger              = $logger;
    }


    /**
     * {@inheritdoc}
     */
    public function sendNotificationToTrials(string $type, string $subject, string $message, ?NotificationTarget $target): void
    {
        $role = UserRoles::ROLE_TRIAL;

        $this->sendNotificationToUserListWithRole($role, $type, $subject, $message, $target);
    }

    /**
     * {@inheritdoc}
     */
    public function sendNotificationToMembers(string $type, string $subject, string $message, ?NotificationTarget $target): void
    {
        $role = UserRoles::ROLE_MEMBER;

        $this->sendNotificationToUserListWithRole($role, $type, $subject, $message, $target);
    }

    /**
     * {@inheritdoc}
     */
    public function sendNotificationToOfficers(string $type, string $subject, string $message, ?NotificationTarget $target): void
    {
        $role = UserRoles::ROLE_OFFICER;

        $this->sendNotificationToUserListWithRole($role, $type, $subject, $message, $target);
    }

    /**
     * {@inheritdoc}
     */
    public function sendNotificationToUser(User $user, string $type, string $subject, string $message, ?NotificationTarget $target): void
    {
        $this->logger->debug(
            'Sending notification to user.',
            array('user' => $user->getId(), 'subject' => $subject, 'method' => 'sendNotificationToUserListWithRole', 'class' => self::class)
        );

        $userList = array($user);

        $this->sendNotificationToUserList($userList, $type, $subject, $message, $target);
    }

    /**
     * {@inheritdoc}
     */
    public function sendNotificationToUserList(array $userList, string $type, string $subject, string $message, ?NotificationTarget $target): void
    {
        $notification = $this->buildNotification($type, $subject, $message, $target);

        $notificationEvent = new NewNotificationEvent($userList, $notification);
        $this->eventDispatcher->dispatch(CoreEvents::NOTIFICATION_NEW, $notificationEvent);
    }

    /**
     * @param string                  $role
     * @param string                  $type
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     */
    protected function sendNotificationToUserListWithRole(string $role,
                                                          string $type,
                                                          string $subject,
                                                          string $message,
                                                          ?NotificationTarget $target): void
    {
        $this->logger->debug(
            'Sending notification to user with role.',
            array('role' => $role, 'subject' => $subject, 'method' => 'sendNotificationToUserListWithRole', 'class' => self::class)
        );

        $userList = $this->userManager->getFilteredListForRole($role, false);

        $this->sendNotificationToUserList($userList, $type, $subject, $message, $target);
    }

    /**
     * @param string                  $type
     * @param string                  $subject
     * @param string                  $message
     * @param NotificationTarget|null $target
     * @return Notification
     */
    protected function buildNotification(string $type, string $subject, string $message, ?NotificationTarget $target): Notification
    {
        $this->logger->debug( 'Building notification.', array(
            'type'    => $type,
            'subject' => $subject,
            'message' => $message,
            'method'  => 'sendNotificationToUserListWithRole',
            'class'   => self::class
        ));

        $dateTime = new \DateTime();

        return $this->notificationBuilder->build($target, $type, $dateTime, $subject, $message);
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 12:39
 */

namespace CoreBundle\Services\Notification;


use CoreBundle\Entity\Notification\Notification;
use CoreBundle\Enum\NotificationTypeEnum;
use CoreBundle\Exception\InvalidArgumentException;
use CoreBundle\Factory\Notification\NotificationFactoryInterface;
use CoreBundle\Manager\Notification\NotificationTypeManagerInterface;
use CoreBundle\Model\NotificationTarget;
use Psr\Log\LoggerInterface;


/**
 * @package CoreBundle\Services\Notification
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationBuilder implements NotificationBuilderInterface
{

    /** @var NotificationTypeManagerInterface */
    protected $notificationTypeManager;
    /** @var NotificationFactoryInterface */
    protected $notificationFactory;
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param NotificationTypeManagerInterface $notificationTypeManager
     * @param NotificationFactoryInterface     $notificationFactory
     * @param LoggerInterface                  $logger
     */
    public function __construct(NotificationTypeManagerInterface $notificationTypeManager, NotificationFactoryInterface $notificationFactory, LoggerInterface $logger)
    {
        $this->notificationTypeManager = $notificationTypeManager;
        $this->notificationFactory     = $notificationFactory;
        $this->logger                  = $logger;
    }


    /**
     * {@inheritdoc}
     */
    public function build(?NotificationTarget $target,
                   string $type,
                   \DateTime $dateTime,
                   string $subject,
                   string $message): Notification
    {
        if (!in_array($type, NotificationTypeEnum::getPossibleTypes()))
            throw new InvalidArgumentException(sprintf('The given type %s is not an available option', $type));

        $this->logger->debug('Building notification.', array('type' => $type, 'subject' => $subject, 'method' => 'build', 'class' => self::class));

        $notificationType = $this->notificationTypeManager->getByType($type);

        return $this->notificationFactory->new($notificationType, $target, $dateTime, $subject, $message);
    }

}
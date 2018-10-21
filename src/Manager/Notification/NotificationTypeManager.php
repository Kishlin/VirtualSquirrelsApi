<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 11:58
 */

namespace App\Manager\Notification;


use Psr\Log\LoggerInterface;
use App\Manager\BaseManager;
use App\Entity\Notification\NotificationType;
use App\Exception\RuntimeException;
use Doctrine\Common\Persistence\ObjectManager;
use App\Repository\Notification\NotificationTypeRepository;
use App\Factory\Notification\NotificationTypeFactoryInterface;

/**
 * @package App\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationTypeManager extends BaseManager implements NotificationTypeManagerInterface
{

    /** @var NotificationTypeFactoryInterface */
    protected $factory;

    /** @var NotificationTypeRepository */
    protected $repository;

    /**
     * @param LoggerInterface                  $logger
     * @param ObjectManager                    $objectManager
     * @param NotificationTypeFactoryInterface $notificationTypeFactory
     */
    public function __construct(LoggerInterface $logger, ObjectManager $objectManager, NotificationTypeFactoryInterface $notificationTypeFactory)
    {
        parent::__construct($logger, $objectManager);

        $this->repository = $objectManager->getRepository(NotificationType::REPOSITORY);
        $this->factory    = $notificationTypeFactory;
    }


    /**
     * {@inheritdoc}
     */
    public function getByType(string $type): NotificationType
    {
        try {
            return $this->repository->findOneByType($type) ?? $this->createNonexistentNotificationType($type);
        } catch(\Exception $e) {
            $message = 'Exception occurred when trying to fetch Notification Type.';
            $this->logger->error($message, array(
                'type'   => $type,
                'method' => 'getByType',
                'class'  => self::class
            ));

            throw new RuntimeException($message, $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save(NotificationType $notificationType): void
    {
        $this->objectManager->persist($notificationType);

        $this->doFlush();
    }

    /**
     * @param string $type
     * @return NotificationType
     */
    private function createNonexistentNotificationType(string $type): NotificationType
    {
        $notificationType = $this->factory->new($type);

        $this->save($notificationType);

        return $notificationType;
    }

}
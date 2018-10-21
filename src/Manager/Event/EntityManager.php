<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 3:20 PM
 */

namespace App\Manager\Event;


use App\Entity\Event\Event;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;

/**
 * @package App\Manager\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
class EntityManager implements EntityManagerInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var ObjectManager */
    protected $objectManager;

    /**
     * @param LoggerInterface                    $logger
     * @param ObjectManager                      $objectManager
     */
    public function __construct(LoggerInterface $logger, ObjectManager $objectManager)
    {
        $this->logger        = $logger;
        $this->objectManager = $objectManager;
    }


    /**
     * {@inheritdoc}
     */
    public function saveEvent(Event $event): Event
    {
        $this->logger->info('Saving event.', array(
            'event'  => $event->getId() ?? 'new',
            'method' => 'saveEvent',
            'class'  => self::class
        ));

        $objectManager = $this->objectManager;

        $objectManager->contains($event) || $objectManager->persist($event);

        $objectManager->flush();

        $objectManager->refresh($event);

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEvent(Event $event): Event
    {
        $this->logger->info('Removing event.', array(
            'event'  => $event->getId(),
            'method' => 'saveEvent',
            'class'  => self::class
        ));

        $this->objectManager->remove($event);

        $this->objectManager->flush();

        return $event;
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 15:00
 */

namespace CoreBundle\Manager\Event;


use CoreBundle\Entity\Event\EventParticipationType;
use CoreBundle\Factory\Event\EventParticipationTypeFactoryInterface;
use CoreBundle\Repository\Event\EventParticipationTypeRepository;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationTypeManager implements EventParticipationTypeManagerInterface
{

    /** @var ObjectManager */
    protected $objectManager;

    /** @var EventParticipationTypeFactoryInterface */
    protected $factory;

    /**
     * @param ObjectManager                          $objectManager
     * @param EventParticipationTypeFactoryInterface $eventParticipationTypeFactory
     */
    public function __construct(ObjectManager $objectManager, EventParticipationTypeFactoryInterface $eventParticipationTypeFactory)
    {
        $this->objectManager = $objectManager;
        $this->factory       = $eventParticipationTypeFactory;
    }


    /**
     * {@inheritdoc}
     */
    public function save(EventParticipationType $eventParticipationType): void
    {
        $this->objectManager->persist($eventParticipationType);

        $this->objectManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getByType(int $type): EventParticipationType
    {
        /** @var EventParticipationType $eventParticipationType */
        $eventParticipationType = $this->getRepository()->findOneBy(array('type' => $type));

        return $eventParticipationType ?? $this->createNonexistentEventParticipationType($type);
    }

    /**
     * @param int $type
     * @return EventParticipationType
     */
    private function createNonexistentEventParticipationType(int $type): EventParticipationType
    {
        $eventParticipationType = $this->factory->new($type);

        $this->save($eventParticipationType);

        return $eventParticipationType;
    }

    /**
     * @return EventParticipationTypeRepository
     */
    private function getRepository(): EventParticipationTypeRepository
    {
        /** @var EventParticipationTypeRepository $repo */
        $repo = $this->objectManager->getRepository(EventParticipationType::REPOSITORY);

        return $repo;
    }

}
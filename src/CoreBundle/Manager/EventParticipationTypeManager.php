<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 15:00
 */

namespace CoreBundle\Manager;


use CoreBundle\Entity\EventParticipationType;
use CoreBundle\Repository\EventParticipationTypeRepository;
use Doctrine\Common\Persistence\ObjectManager;


/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationTypeManager implements EventParticipationTypeManagerInterface
{

    /** @var ObjectManager */
    protected $objectManager;

    /**
     * @param ObjectManager $objectManager
     */
    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getByType(int $type): ?EventParticipationType
    {
        /** @var EventParticipationType $object */
        $object = $this->getRepository()->findOneBy(array('type' => $type));

        return $object;
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
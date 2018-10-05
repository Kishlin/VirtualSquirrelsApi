<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 12:59
 */

namespace CoreBundle\Fixtures\ORM\Event;


use CoreBundle\Entity\Event\EventParticipationType;
use CoreBundle\Enum\EventParticipationTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @package CoreBundle\Fixtures\ORM
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationTypeFixtures extends Fixture
{

    /** @var array */
    CONST REFERENCES = array(
        EventParticipationTypeEnum::TYPE_POSITIVE => 'reference-positive',
        EventParticipationTypeEnum::TYPE_NEGATIVE => 'reference-negative',
        EventParticipationTypeEnum::TYPE_UNSURE   => 'reference-unsure',
        EventParticipationTypeEnum::TYPE_BACKUP   => 'reference-backup',
    );

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (EventParticipationTypeEnum::getPossibleTypes() as $type) {
            $eventParticipationType = new EventParticipationType();
            $eventParticipationType->setType($type);

            $this->setReference(self::REFERENCES[$type], $eventParticipationType);

            $manager->persist($eventParticipationType);
        }

        $manager->flush();
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 12:59
 */

namespace CoreBundle\Fixtures\ORM;


use CoreBundle\Entity\EventParticipationType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @package CoreBundle\Fixtures\ORM
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationTypeFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach (EventParticipationType::getPossibleTypes() as $type) {
            $eventParticipationType = new EventParticipationType();
            $eventParticipationType->setType($type);

            $manager->persist($eventParticipationType);
        }

        $manager->flush();
    }


}
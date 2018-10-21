<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:05 AM
 */

namespace App\DataFixtures\ORM\Event;


use App\Entity\Event\Event;
use App\Entity\Event\EventParticipation;
use App\Entity\Event\EventParticipationType;
use App\Enum\EventParticipationTypeEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\User;
use App\DataFixtures\ORM\User\UserTrialFixtures;

/**
 * @package App\DataFixtures\ORM\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class EventParticipationFixtures extends Fixture implements DependentFixtureInterface
{

    const PARTICIPATION_TYPE = EventParticipationTypeEnum::TYPE_POSITIVE;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $type  = $this->getReference(EventParticipationTypeFixtures::REFERENCES[self::PARTICIPATION_TYPE]); /** @var EventParticipationType $type */
        $event = $this->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user  = $this->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $eventParticipation = new EventParticipation();
        $eventParticipation->setEventParticipationType($type);
        $eventParticipation->setParticipant($user);
        $eventParticipation->setEvent($event);

        $manager->persist($eventParticipation);

        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return array(
            EventParticipationTypeFixtures::class,
            EventSingletonFixtures::class,
            UserTrialFixtures::class
        );
    }

}

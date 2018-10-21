<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 10:25
 */

namespace App\DataFixtures\ORM\Event;


use App\DataFixtures\Util\Factory\Event\EventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @package App\DataFixtures\ORM\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventSingletonFixtures extends Fixture
{

    /** @var string */
    const EVENT_REFERENCE = 'event-singleton';

    /** @var EventFactory */
    protected $eventFactory;

    /**
     * @param EventFactory $eventFactory
     */
    public function __construct(EventFactory $eventFactory)
    {
        $this->eventFactory = $eventFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $event = $this->eventFactory->defaultEvent('event');

        $manager->persist($event);
        $manager->flush();

        $this->addReference(self::EVENT_REFERENCE, $event);
    }

}
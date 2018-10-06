<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 19:01
 */

namespace CoreBundle\Tests\EventSubscriber;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Entity\Event\EventParticipation;
use CoreBundle\Entity\Event\EventParticipationType;
use CoreBundle\Enum\EventParticipationTypeEnum;
use CoreBundle\Event\Event\EventFinalizeEvent;
use CoreBundle\EventSubscriber\Event\FinalizeEventListener;
use CoreBundle\Fixtures\ORM\Event\EventParticipationTypeFixtures;
use CoreBundle\Fixtures\ORM\Event\EventSingletonFixtures;
use JMS\Serializer\SerializerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Fixtures\ORM\UserSingletonFixtures;

/**
 * @package CoreBundle\Tests\EventSubscriber
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class FinalizeEventListenerTest extends WebTestCase
{

    /**
     * @dataProvider dataSetProvider
     * @param $participationType
     * @param $expectedType
     * @param $emptyTypeList
     * @throws \Exception
     */
    public function testSerialization(int $participationType, string $expectedType, array $emptyTypeList)
    {
        $fixtures = $this->loadFixtures(array(
            EventSingletonFixtures::class,
            UserSingletonFixtures::class,
            EventParticipationTypeFixtures::class
        ))->getReferenceRepository();

        $event = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user  = $fixtures->getReference(UserSingletonFixtures::REFERENCE); /** @var User $user */
        $type  = $fixtures->getReference(EventParticipationTypeFixtures::REFERENCES[$participationType]); /** @var EventParticipationType $type */

        $eventParticipation = new EventParticipation();
        $eventParticipation->setParticipant($user);
        $eventParticipation->setEvent($event);
        $eventParticipation->setEventParticipationType($type);

        $user->addEventParticipationList($eventParticipation);
        $event->addEventParticipationList($eventParticipation);

        $dispatcherEvent = new EventFinalizeEvent($user, $event);
        $this->getListener()->setResponse($dispatcherEvent);

        $response = $dispatcherEvent->getResponse();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $content = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('id',        $content);
        $this->assertArrayHasKey('name',      $content);
        $this->assertArrayHasKey('startDate', $content);
        $this->assertArrayHasKey('endDate',   $content);
        $this->assertArrayHasKey('answers',   $content);

        $this->assertArrayHasKey('positive', $content['answers']);
        $this->assertArrayHasKey('negative', $content['answers']);
        $this->assertArrayHasKey('unsure',   $content['answers']);
        $this->assertArrayHasKey('backup',   $content['answers']);

        $this->assertEquals($event->getId(),                           $content['id']);
        $this->assertEquals($event->getName(),                         $content['name']);
        $this->assertEquals($event->getStartDate()->format(DATE_ATOM), $content['startDate']);
        $this->assertEquals($event->getEndDate()->format(DATE_ATOM),   $content['endDate']);

        $this->assertArrayHasKey($user->getId(), $content['answers'][$expectedType]);

        $this->assertArrayHasKey('id', $content['answers'][$expectedType][$user->getId()]);

        $this->assertEquals($user->getId(), $content['answers'][$expectedType][$user->getId()]['id']);

        foreach ($emptyTypeList as $blankType) {
            $this->assertEmpty($content['answers'][$blankType]);
        }
    }

    /**
     * @return array
     */
    public function dataSetProvider(): array
    {
        return array(
            array(EventParticipationTypeEnum::TYPE_POSITIVE, 'positive', array('negative', 'unsure',   'backup')),
            array(EventParticipationTypeEnum::TYPE_NEGATIVE, 'negative', array('positive', 'unsure',   'backup')),
            array(EventParticipationTypeEnum::TYPE_UNSURE  , 'unsure',   array('positive', 'negative', 'backup')),
            array(EventParticipationTypeEnum::TYPE_BACKUP  , 'backup',   array('positive', 'negative', 'unsure'))
        );
    }

    /**
     * @return FinalizeEventListener
     */
    protected function getListener(): FinalizeEventListener
    {
        $container  = $this->getContainer();

        /** @var LoggerInterface $logger */
        $logger     = $this->getMockBuilder(LoggerInterface::class)->getMockForAbstractClass();
        /** @var SerializerInterface $serializer */
        $serializer = $container->get('jms_serializer');

        return new FinalizeEventListener($logger, $serializer);
    }

}

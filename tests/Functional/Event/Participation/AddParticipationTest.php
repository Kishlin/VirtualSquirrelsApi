<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 18:41
 */

namespace Tests\Functional\Event\Participation;


use App\Entity\Event\Event;
use App\Entity\Event\EventParticipation;
use App\Enum\EventParticipationTypeEnum;
use App\DataFixtures\ORM\Event\EventParticipationFixtures;
use App\DataFixtures\ORM\Event\EventSingletonFixtures;
use App\Entity\User;
use App\DataFixtures\ORM\User\UserTrialFixtures;

/**
 * @package Tests\Functional\Event\Participation
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AddParticipationTest extends BaseParticipationTest
{

    /**
     * @throws \Exception
     */
    public function testInvalidParticipationType()
    {
        $fixtures = $this->loadFixtures(array(EventSingletonFixtures::class, UserTrialFixtures::class))->getReferenceRepository();
        $event    = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user     = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), max(EventParticipationTypeEnum::getPossibleTypes()) + 1));

        $this->assertErrorResponse($client, 400);
    }

    /**
     * @dataProvider existingParticipationProvider
     * @param array $fixtures
     * @param int   $type
     * @throws \Exception
     */
    public function testValidRequest(array $fixtures, int $type)
    {
        $fixtures = $this->loadFixtures($fixtures)->getReferenceRepository();
        $event    = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user     = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), $type));

        $this->assertJsonResponse($client);
        $this->assertStatusCode(200, $client);

        $eventParticipationList = $this->getRepository(EventParticipation::REPOSITORY)->findAll();

        $this->assertCount(1, $eventParticipationList);

        /** @var EventParticipation $eventParticipation */
        $eventParticipation = $eventParticipationList[0];

        $this->assertEquals($type,  $eventParticipation->getEventParticipationType()->getType());
        $this->assertEquals($user,  $eventParticipation->getParticipant());
        $this->assertEquals($event, $eventParticipation->getEvent());
    }

    /**
     * @return array
     */
    public function noExistingParticipationProvider(): array
    {
        $fixtures = array(EventSingletonFixtures::class, UserTrialFixtures::class);

        return array_map(
            function(int $type) use($fixtures) { return array($fixtures, $type); },
            EventParticipationTypeEnum::getPossibleTypes()
        );
    }

    /**
     * @return array
     */
    public function existingParticipationProvider(): array
    {
        $fixtures     = array(EventParticipationFixtures::class);

        return array_map(
            function(int $type) use($fixtures) { return array($fixtures, $type); },
            EventParticipationTypeEnum::getPossibleTypes()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getUri(int $eventId, ?int $typeId = EventParticipationTypeEnum::TYPE_POSITIVE): string
    {
        return sprintf('/event/%d/participation/add/%d', $eventId, $typeId);
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 12:38 PM
 */

namespace CoreBundle\Tests\Functional\Event\ForceParticipation;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Entity\Event\EventParticipation;
use CoreBundle\Enum\EventParticipationTypeEnum;
use CoreBundle\Fixtures\ORM\Event\EventParticipationFixtures;
use CoreBundle\Fixtures\ORM\Event\EventSingletonFixtures;
use UserBundle\Entity\User;
use UserBundle\Fixtures\ORM\UserOfficerFixtures;
use UserBundle\Fixtures\ORM\UserTrialFixtures;

/**
 * @package CoreBundle\Tests\Functional\Event\ForceParticipation
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class ForceAddParticipationTest extends BaseForceParticipationTest
{

    /**
     * @throws \Exception
     */
    public function testInvalidParticipationType()
    {
        $fixtureList = array(EventSingletonFixtures::class, UserOfficerFixtures::class, UserTrialFixtures::class);

        $fixtures   = $this->loadFixtures($fixtureList)->getReferenceRepository();
        $event      = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $requesting = $fixtures->getReference(UserOfficerFixtures::REFERENCE); /** @var User $requesting */
        $user       = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($requesting, 'main');

        $client = $this->makeClient();
        $type   = max(EventParticipationTypeEnum::getPossibleTypes()) + 1;
        $client->request('POST', $this->getUri($event->getId(), $user->getId(), $type));

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
        $fixtures   = $this->loadFixtures($fixtures)->getReferenceRepository();
        $event      = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $requesting = $fixtures->getReference(UserOfficerFixtures::REFERENCE); /** @var User $requesting */
        $user       = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($requesting, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), $user->getId(), $type));

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
        $fixtures = array(EventSingletonFixtures::class, UserTrialFixtures::class, UserOfficerFixtures::class);

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
        $fixtures = array(EventParticipationFixtures::class, UserOfficerFixtures::class);

        return array_map(
            function(int $type) use($fixtures) { return array($fixtures, $type); },
            EventParticipationTypeEnum::getPossibleTypes()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getUri(int $eventId, int $userId, ?int $typeId = null): string
    {
        return sprintf('/event/%d/participation/force/%d/add/%d', $eventId, $userId, $typeId);
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 10:54 AM
 */

namespace Tests\Functional\Event\Participation;



use App\Entity\Event\Event;
use App\Entity\Event\EventParticipation;
use App\DataFixtures\ORM\Event\EventParticipationFixtures;
use App\DataFixtures\ORM\Event\EventSingletonFixtures;
use App\Entity\User;
use App\DataFixtures\ORM\User\UserTrialFixtures;

/**
 * @package Tests\Functional\Event\Participation
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class RemoveParticipationTest extends BaseParticipationTest
{

    /**
     * @dataProvider dataSetProvider
     * @param array $fixtureList
     * @param int   $expectedInitialParticipationCount
     * @throws \Exception
     */
    public function testAlreadyHasParticipation(array $fixtureList, int $expectedInitialParticipationCount)
    {
        $fixtures = $this->loadFixtures($fixtureList)->getReferenceRepository();

        $event = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user  = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($user, 'main');

        $eventParticipationList = $this->getRepository(EventParticipation::REPOSITORY)->findAll();
        $this->assertCount($expectedInitialParticipationCount, $eventParticipationList);

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), null));

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $eventParticipationList = $this->getRepository(EventParticipation::REPOSITORY)->findAll();

        $this->assertEmpty($eventParticipationList);
    }

    /**
     * @return array
     */
    public function dataSetProvider(): array
    {
        return array(
            'no participation'       => array(array(UserTrialFixtures::class, EventSingletonFixtures::class), 0),
            'existing participation' => array(array(EventParticipationFixtures::class), 1),
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getUri(int $eventId, ?int $typeId = null): string
    {
        return sprintf('/event/%d/participation/remove', $eventId);
    }

}

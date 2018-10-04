<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 18:41
 */

namespace CoreBundle\Tests\Functional\Event\Participation;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Enum\EventParticipationTypeEnum;
use CoreBundle\Fixtures\ORM\Event\EventSingletonFixtures;
use CoreBundle\Tests\Functional\Util\WebTestCase;
use UserBundle\Entity\User;
use UserBundle\Fixtures\ORM\UserSingletonFixtures;
use UserBundle\Fixtures\ORM\UserTrialFixtures;


/**
 * @package CoreBundle\Tests\Functional\Event\Participation
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AddParticipationTest extends WebTestCase
{

    /**
     * @throws \Exception
     */
    public function testNotLoggedIn()
    {
        $fixtures = $this->loadFixtures(array(EventSingletonFixtures::class))->getReferenceRepository();
        $event    = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId()));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @throws \Exception
     */
    public function testDoesNotHaveRole()
    {
        $fixtures = $this->loadFixtures(array(EventSingletonFixtures::class, UserSingletonFixtures::class))->getReferenceRepository();
        $event    = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user     = $fixtures->getReference(UserSingletonFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId()));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @throws \Exception
     */
    public function testEventNotFound()
    {
        $fixtures = $this->loadFixtures(array(EventSingletonFixtures::class, UserTrialFixtures::class))->getReferenceRepository();
        $event    = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user     = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId() + 1));

        $this->assertErrorResponse($client, 404);
    }

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

        $this->assertErrorResponse($client, 500);
    }

    /**
     * @throws \Exception
     */
    public function testValidRequest()
    {
        $fixtures = $this->loadFixtures(array(EventSingletonFixtures::class, UserTrialFixtures::class))->getReferenceRepository();
        $event    = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user     = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), EventParticipationTypeEnum::TYPE_POSITIVE));

        $this->assertJsonResponse($client);
        $this->assertStatusCode(200, $client);

        $response = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id',        $response);
        $this->assertArrayHasKey('name',      $response);
        $this->assertArrayHasKey('startDate', $response);
        $this->assertArrayHasKey('endDate',   $response);
        $this->assertArrayHasKey('answers',   $response);

        $this->assertArrayHasKey('positive', $response['answers']);
        $this->assertArrayHasKey('negative', $response['answers']);
        $this->assertArrayHasKey('unsure',   $response['answers']);
        $this->assertArrayHasKey('backup',   $response['answers']);

        $this->assertEquals($event->getId(),                           $response['id']);
        $this->assertEquals($event->getName(),                         $response['name']);
        $this->assertEquals($event->getStartDate()->format(DATE_ATOM), $response['startDate']);
        $this->assertEquals($event->getEndDate()->format(DATE_ATOM),   $response['endDate']);

        $this->assertArrayHasKey($user->getId(), $response['answers']['positive']);

        $this->assertArrayHasKey('id', $response['answers']['positive'][$user->getId()]);

        $this->assertEquals($user->getId(), $response['answers']['positive'][$user->getId()]['id']);

        $this->assertEmpty($response['answers']['negative']);
        $this->assertEmpty($response['answers']['unsure']);
        $this->assertEmpty($response['answers']['backup']);
        $this->assertCount(1, $response['answers']['positive']);
    }

    /**
     * @param int $eventId
     * @param int $typeId
     * @return string
     */
    protected function getUri(int $eventId, int $typeId = EventParticipationTypeEnum::TYPE_POSITIVE): string
    {
        return sprintf('/event/%d/participation/add/%d', $eventId, $typeId);
    }

}

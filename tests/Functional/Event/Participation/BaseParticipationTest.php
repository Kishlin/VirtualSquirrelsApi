<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 10:56 AM
 */

namespace Tests\Functional\Event\Participation;


use App\Entity\Event\Event;
use App\DataFixtures\ORM\Event\EventSingletonFixtures;
use Tests\Functional\Util\WebTestCase;
use App\Entity\User;
use App\DataFixtures\ORM\User\UserSingletonFixtures;
use App\DataFixtures\ORM\User\UserTrialFixtures;

/**
 * @package Tests\Functional\Event\Participation
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
abstract class BaseParticipationTest extends WebTestCase
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
     * @param int      $eventId
     * @param int|null $typeId
     * @return string
     */
    abstract protected function getUri(int $eventId, ?int $typeId = null): string;

}
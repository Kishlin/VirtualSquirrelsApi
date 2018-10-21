<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 12:21 PM
 */

namespace Tests\Functional\Event\ForceParticipation;


use App\Entity\Event\Event;
use App\DataFixtures\ORM\Event\EventSingletonFixtures;
use Tests\Functional\Util\WebTestCase;
use App\Entity\User;
use App\DataFixtures\ORM\User\UserMemberFixtures;
use App\DataFixtures\ORM\User\UserOfficerFixtures;
use App\DataFixtures\ORM\User\UserTrialFixtures;

/**
 * @package Tests\Functional\Event\ForceParticipation
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
abstract class BaseForceParticipationTest extends WebTestCase
{

    /**
     * @throws \Exception
     */
    public function testNotLoggedIn()
    {
        $fixtures = $this->loadFixtures(array(EventSingletonFixtures::class, UserTrialFixtures::class))->getReferenceRepository();
        $event    = $fixtures->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user     = $fixtures->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), $user->getId()));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @throws \Exception
     */
    public function testDoesNotHaveRole()
    {
        $fixtureList = array(EventSingletonFixtures::class, UserMemberFixtures::class, UserTrialFixtures::class);

        $fixtureList = $this->loadFixtures($fixtureList)->getReferenceRepository();
        $event       = $fixtureList->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user        = $fixtureList->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */
        $requesting  = $fixtureList->getReference(UserMemberFixtures::REFERENCE); /** @var User $requesting */

        $this->loginAs($requesting, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), $user->getId()));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @throws \Exception
     */
    public function testEventNotFound()
    {
        $fixtureList = array(EventSingletonFixtures::class, UserOfficerFixtures::class, UserTrialFixtures::class);

        $fixtureList = $this->loadFixtures($fixtureList)->getReferenceRepository();
        $event       = $fixtureList->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user        = $fixtureList->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */
        $requesting  = $fixtureList->getReference(UserOfficerFixtures::REFERENCE); /** @var User $requesting */

        $this->loginAs($requesting, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId() + 1, $user->getId()));

        $this->assertErrorResponse($client, 404);
    }

    /**
     * @throws \Exception
     */
    public function testUserNotFound()
    {
        $fixtureList = array(EventSingletonFixtures::class, UserOfficerFixtures::class, UserTrialFixtures::class);

        $fixtureList = $this->loadFixtures($fixtureList)->getReferenceRepository();
        $event       = $fixtureList->getReference(EventSingletonFixtures::EVENT_REFERENCE); /** @var Event $event */
        $user        = $fixtureList->getReference(UserTrialFixtures::REFERENCE); /** @var User $user */
        $requesting  = $fixtureList->getReference(UserOfficerFixtures::REFERENCE); /** @var User $requesting */

        $this->loginAs($requesting, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->getUri($event->getId(), $user->getId() + 1));

        $this->assertErrorResponse($client, 404);
    }

    /**
     * @param int      $eventId
     * @param int      $userId
     * @param int|null $typeId
     * @return string
     */
    abstract protected function getUri(int $eventId, int $userId, ?int $typeId = null): string;

}

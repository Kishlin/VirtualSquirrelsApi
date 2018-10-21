<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 17:01
 */

namespace Tests\Functional\Security;


use App\Entity\User;
use App\DataFixtures\ORM\User\UserSingletonFixtures;
use App\Handler\Security\LogoutSuccess;
use Tests\Functional\Util\WebTestCase;

/**
 * @package Tests\Functional\Security
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class LogoutTest extends WebTestCase
{

    /**
     * @throws \Exception
     */
    public function testNotLoggedIn()
    {
        $this->loadFixtures(array());

        $this->proceed();
    }

    /**
     * @throws \Exception
     */
    public function testLoggedIn()
    {
        $fixtures = $this->loadFixtures(array(UserSingletonFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserSingletonFixtures::REFERENCE);
        $this->loginAs($user, 'main');

        $this->proceed();
    }

    /**
     * @throws \Exception
     */
    private function proceed(): void
    {
        $client = $this->makeClient();
        $client->request('POST', '/security/logout');

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $this->assertCount(1, $response = json_decode($client->getResponse()->getContent(), true));
        $this->assertArrayHasKey('message', $response);

        $this->assertEquals(LogoutSuccess::MESSAGE, $response['message']);
    }

}
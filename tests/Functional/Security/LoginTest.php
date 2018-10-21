<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 16:37
 */

namespace Tests\Functional\Security;


use App\DataFixtures\ORM\User\DisabledUserFixtures;
use App\DataFixtures\ORM\User\UserSingletonFixtures;
use Tests\Functional\Util\WebTestCase;

/**
 * @package Tests\Functional\Security
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class LoginTest extends WebTestCase
{

    /**
     * @dataProvider errorProvider
     * @param array  $parameters
     * @param string $message
     * @param array  $fixtures
     * @throws \Exception
     */
    public function testErrors(array $parameters, string $message, array $fixtures)
    {
        $this->loadFixtures($fixtures);

        $client = $this->makeClient();
        $client->request('POST', '/security/login', $parameters);

        $this->assertStatusCode(500, $client);
        $this->assertJsonResponse($client);

        $this->assertCount(2, $response = json_decode($client->getResponse()->getContent(), true));
        $this->assertArrayHasKey('exception', $response);
        $this->assertArrayHasKey('message', $response);

        $this->assertEquals($message, $response['exception']['message']);
    }

    public function errorProvider()
    {
        return array(
            array(array('_username' => 'user',     '_password' => 'changeme'),      'Bad credentials.',          array()),
            array(array('_username' => 'user',     '_password' => 'wrongPassword'), 'Bad credentials.',          array(UserSingletonFixtures::class)),
            array(array('_username' => 'disabled', '_password' => 'changeme'),      'User account is disabled.', array(DisabledUserFixtures::class)),
        );
    }

    /**
     * @throws \Exception
     */
    public function testGoodCredentials()
    {
        $this->loadFixtures(array(UserSingletonFixtures::class));

        $parameters = array('_username' => 'user', '_password' => 'changeme');

        $client = $this->makeClient();
        $client->request('POST', '/security/login', $parameters);

        $this->assertStatusCode(303, $client);
        $this->assertJsonResponse($client);

        $this->assertEquals('/loading', $client->getResponse()->headers->get('location'));
    }

}
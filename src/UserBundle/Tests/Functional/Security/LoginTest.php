<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 16:37
 */

namespace UserBundle\Tests\Functional\Security;


use UserBundle\Fixtures\ORM\DisabledUserFixtures;
use UserBundle\Fixtures\ORM\UserSingletonFixtures;
use UserBundle\Tests\Functional\Util\WebTestCase;

/**
 * @package UserBundle\Tests\Functional\Security
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
            array(array('_username' => 'user', '_password' => 'changeme'), 'Bad credentials.', array()),
            array(array('_username' => 'user', '_password' => 'wrongPassword'), 'Bad credentials.', array(UserSingletonFixtures::class)),
            array(array('_username' => 'user', '_password' => 'changeme'), 'User account is disabled.', array(DisabledUserFixtures::class)),
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

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $this->assertCount(1, $response = json_decode($client->getResponse()->getContent(), true));
        $this->assertArrayHasKey('email', $response);

        $this->assertEquals('example@gmail.com', $response['email']);
    }

}
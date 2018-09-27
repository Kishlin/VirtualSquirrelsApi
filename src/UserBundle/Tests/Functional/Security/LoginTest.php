<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 16:37
 */

namespace UserBundle\Tests\Functional\Security;


use UserBundle\Fixtures\ORM\UserSingletonFixtures;
use UserBundle\Tests\Functional\Util\WebTestCase;

/**
 * @package UserBundle\Tests\Functional\Security
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class LoginTest extends WebTestCase
{

    /**
     * @throws \Exception
     */
    public function testNonextantUser()
    {
        $this->loadFixtures();

        $parameters = array('_username' => 'user', '_password' => 'changeme');

        $client = $this->makeClient();
        $client->request('POST', '/security/login', array('fos_user_registration_form' => $parameters));

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $this->assertCount(2, $response = json_decode($client->getResponse()->getContent(), true));
        var_dump($response);
    }

    /**
     * @throws \Exception
     */
    public function testBadCredentials()
    {
        $this->loadFixtures(UserSingletonFixtures::class);

        $parameters = array('_username' => 'user', '_password' => 'wrongPassword');

        $client = $this->makeClient();
        $client->request('POST', '/security/login', array('fos_user_registration_form' => $parameters));

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $this->assertCount(2, $response = json_decode($client->getResponse()->getContent(), true));
        var_dump($response);
    }

    /**
     * @throws \Exception
     */
    public function testGoodCredentials()
    {
        $this->loadFixtures(UserSingletonFixtures::class);

        $parameters = array('_username' => 'user', '_password' => 'changeme');

        $client = $this->makeClient();
        $client->request('POST', '/security/login', array('fos_user_registration_form' => $parameters));

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $this->assertCount(1, $response = json_decode($client->getResponse()->getContent(), true));
        $this->assertArrayHasKey('email', $response);

        $this->assertEquals('example@gmail.com', $response['email']);
    }

}
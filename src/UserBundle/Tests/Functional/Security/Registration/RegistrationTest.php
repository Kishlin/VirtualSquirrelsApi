<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 11:12
 */

namespace UserBundle\Tests\Security\Registration;


use UserBundle\EventSubscriber\Registration\InitializeListener;
use UserBundle\Tests\Functional\Util\WebTestCase;

/**
 * @package UserBundle\Tests\Security\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RegistrationTest extends WebTestCase
{

    /**
     * @dataProvider exceptionProvider
     * @param array $parameters
     * @throws \Exception
     */
    public function testThrowsException(array $parameters)
    {
        $client = $this->makeClient();
        $client->request('POST', '/security/registration/register', $parameters);

        $response = $client->getResponse();

        $this->assertStatusCode(400, $client);
        $this->assertJsonResponse($client);

        $content = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('requirements', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertCount(2, $content);

        $this->assertEquals(InitializeListener::ERROR_MESSAGE, $content['message']);
    }

    /**
     * @return array
     */
    public function exceptionProvider(): array
    {
        return array(
            array(array()),
            array(array('invalidKey' => 'invalidValue'))
        );
    }

}
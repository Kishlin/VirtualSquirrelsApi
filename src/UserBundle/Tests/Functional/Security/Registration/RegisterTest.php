<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 11:12
 */

namespace UserBundle\Tests\Security\Registration;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use UserBundle\EventSubscriber\Registration\InitializeListener;

/**
 * @package UserBundle\Tests\Security\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RegisterTest extends WebTestCase
{

    /**
     * @dataProvider exceptionProvider
     * @param array $parameters
     * @throws \Exception
     */
    public function testThrowsException(array $parameters)
    {
        $client = static::createClient();

        $client->request('POST', '/security/registration/register', $parameters);

        $response = $client->getResponse();

        $this->assertEquals('application/json', $response->headers->get('content-type'));
        $this->assertEquals(400, $response->getStatusCode());

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
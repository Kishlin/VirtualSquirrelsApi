<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 10:45
 */

namespace Tests\Functional\Util;


use App\Services\HttpFoundation\ExceptionResponseBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase as BaseClass;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * @package Tests\Functional\Util
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class WebTestCase extends BaseClass
{

    /** @var ObjectManager */
    protected $objectManager;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->objectManager = $this->getContainer()->get('doctrine');
    }


    /**
     * @param Client $client
     * @throws \Exception
     */
    public function assertJsonResponse(Client $client): void
    {
        $this->assertEquals('application/json', $client->getResponse()->headers->get('content-type'));
    }

    /**
     * @param Client $client
     * @param int    $code
     * @throws \Exception
     */
    public function assertErrorResponse(Client $client, int $code = 500): void
    {
        $this->assertStatusCode($code, $client);
        $this->assertJsonResponse($client);

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message',   $response);
        $this->assertArrayHasKey('exception', $response);
        $this->assertArrayHasKey('message',   $response['exception']);

        $this->assertEquals(ExceptionResponseBuilderInterface::MESSAGE, $response['message']);
    }

    /**
     * @param string $class
     * @return ObjectRepository
     */
    public function getRepository(string $class): ObjectRepository
    {
        return $this->objectManager->getRepository($class);
    }

}
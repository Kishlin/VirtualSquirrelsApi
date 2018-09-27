<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 12:19
 */

namespace UserBundle\Tests\Functional\Util;


use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Liip\FunctionalTestBundle\Test\WebTestCase as BaseClass;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * @package UserBundle\Tests\Functional\Util
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
     * @param string $class
     * @return ObjectRepository
     */
    public function getRepository(string $class): ObjectRepository
    {
        return $this->objectManager->getRepository($class);
    }

}
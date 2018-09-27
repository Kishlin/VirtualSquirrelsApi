<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 12:19
 */

namespace UserBundle\Tests\Functional\Util;


use Liip\FunctionalTestBundle\Test\WebTestCase as BaseClass;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * @package UserBundle\Tests\Functional\Util
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class WebTestCase extends BaseClass
{

    /**
     * @param Client $client
     * @throws \Exception
     */
    public function assertJsonResponse(Client $client)
    {
        $this->assertEquals('application/json', $client->getResponse()->headers->get('content-type'));
    }

}
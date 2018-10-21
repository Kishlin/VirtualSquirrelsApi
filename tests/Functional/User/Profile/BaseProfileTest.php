<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 09:48
 */

namespace Tests\Functional\User\Profile;


use Tests\Functional\Util\WebTestCase;

/**
 * @package Tests\Functional\User\Profile
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
abstract class BaseProfileTest extends WebTestCase
{

    /**
     * @throws \Exception
     */
    public function testNotLoggedIn()
    {
        $this->loadFixtures();

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri());

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @return string
     */
    abstract protected function buildUri(): string;

}
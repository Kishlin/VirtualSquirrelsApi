<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 4:07 PM
 */

namespace Tests\Functional\Event\Entity;


use App\Entity\Event\Event;
use Tests\Functional\Util\WebTestCase;
use App\Entity\User;
use App\DataFixtures\ORM\User\UserTrialFixtures;

/**
 * @package Tests\Functional\Event\Entity
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
class NotSubmittedFormTest extends WebTestCase
{

    /**
     * @dataProvider exceptionProvider
     * @param array $parameters
     * @throws \Exception
     */
    public function testThrowsException(array $parameters)
    {
        $fixtures = $this->loadFixtures(array(UserTrialFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserTrialFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', '/event/new', $parameters);

        $this->assertStatusCode(400, $client);
        $this->assertJsonResponse($client);

        $this->assertEmpty($this->getRepository(Event::REPOSITORY)->findAll());
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
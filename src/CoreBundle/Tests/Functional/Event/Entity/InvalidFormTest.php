<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 4:30 PM
 */

namespace CoreBundle\Tests\Functional\Event\Entity;


use CoreBundle\CoreForms;
use CoreBundle\Entity\Event\Event;
use UserBundle\Entity\User;
use UserBundle\Fixtures\ORM\UserTrialFixtures;

/**
 * @package CoreBundle\Tests\Functional\Event\Creation
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
class InvalidFormTest extends BaseFormTest
{

    /**
     * @dataProvider exceptionProvider
     * @param array $parameters
     * @param array $failures
     * @throws \Exception
     */
    public function testThrowsException(array $parameters, array $failures)
    {
        $fixtures = $this->loadFixtures(array(UserTrialFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserTrialFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', '/event/new', array(CoreForms::FORM_EVENT => $parameters));

        $this->assertStatusCode(400, $client);
        $this->assertJsonResponse($client);

        $this->assertEmpty($this->getRepository(Event::REPOSITORY)->findAll());

        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($failures, array_keys($response['errors']));
    }

}
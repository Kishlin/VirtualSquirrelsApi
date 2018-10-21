<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/21/18
 * Time: 12:04 AM
 */

namespace Tests\Functional\Event\Entity;


use App\CoreForms;
use App\Entity\Event\Event;
use App\Entity\User;
use App\DataFixtures\ORM\User\UserTrialFixtures;

/**
 * @package Tests\Functional\Event\Creation
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
class ValidFormTest extends BaseFormTest
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

    /**
     * @throws \Exception
     */
    public function testValidFormPost()
    {
        $fixtures = $this->loadFixtures(array(UserTrialFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserTrialFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $parameters = $this->buildParametersArray();

        $client = $this->makeClient();
        $client->request('POST', '/event/new', array(CoreForms::FORM_EVENT => $parameters));

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $eventList = $this->getRepository(Event::REPOSITORY)->findAll();
        $this->assertCount(1, $eventList);

        /** @var Event $event */
        $event  = $eventList[0];
        $format = Event::DATE_FORMAT;

        $this->assertEquals($parameters['name'],      $event->getName());
        $this->assertEquals($parameters['startDate'], $event->getStartDate()->format($format));
        $this->assertEquals($parameters['endDate'],   $event->getEndDate()->format($format));
    }
    
}
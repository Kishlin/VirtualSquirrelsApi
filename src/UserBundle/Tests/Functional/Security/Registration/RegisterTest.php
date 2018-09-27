<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 11:12
 */

namespace UserBundle\Tests\Security\Registration;


use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;
use UserBundle\EventSubscriber\Registration\FailureListener;
use UserBundle\EventSubscriber\Registration\InitializeListener;
use UserBundle\EventSubscriber\Registration\SuccessListener;
use UserBundle\Fixtures\ORM\UserSingletonFixtures;
use UserBundle\Tests\Functional\Util\WebTestCase;

/**
 * @package UserBundle\Tests\Security\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RegisterTest extends WebTestCase
{

    const MATCHING_PASSWORD = array('first' => 'changeme', 'second' => 'changeme');

    const INVALID_PASSWORD  = array('first' => 'changeme', 'second' => 'changeme2');

    /**
     * @dataProvider exceptionProvider
     * @param array $parameters
     * @throws \Exception
     */
    public function testThrowsException(array $parameters)
    {
        $this->loadFixtures();

        $client = $this->makeClient();
        $client->request('POST', '/security/registration/register', $parameters);

        $this->assertStatusCode(400, $client);
        $this->assertJsonResponse($client);

        $content = json_decode($client->getResponse()->getContent(), true);
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

    /**
     * @dataProvider formErrorProvider
     * @param array  $parameters
     * @param string $key
     * @param string $error
     * @throws \Exception
     */
    public function testFormError(array $parameters, string $key, string $error)
    {
        $this->loadFixtures(array(UserSingletonFixtures::class));

        $client = $this->makeClient();
        $client->request('POST', '/security/registration/register', array('fos_user_registration_form' => $parameters));

        $this->assertStatusCode(400, $client);
        $this->assertJsonResponse($client);

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertArrayHasKey('errors', $content);
        $this->assertCount(2, $content);

        $this->assertArrayHasKey($key, $content['errors']);
        $this->assertCount(1, $content['errors']);

        $this->assertEquals(FailureListener::ERROR_MESSAGE, $content['message']);
        $this->assertEquals($error, $content['errors'][$key]);
    }

    /**
     * @return array
     */
    public function formErrorProvider(): array
    {
        $matching = self::MATCHING_PASSWORD;
        $invalid  = self::INVALID_PASSWORD;

        return array(
            array(array('email' => 'example2@gmail.com', 'username' => 'user2'), 'password', FailureListener::ERRORS[NotBlank::class]),
            array(array('email' => 'example2@gmail.com', 'plainPassword' => $matching), 'username', FailureListener::ERRORS[NotBlank::class]),
            array(array('username' => 'user2', 'plainPassword' => $matching), 'email', FailureListener::ERRORS[NotBlank::class]),
            array(array('email' => 'example2@gmail.com', 'username' => 'user2', 'plainPassword' => $invalid), 'password', FailureListener::ERRORS[Form::class]),
            array(array('email' => 'notAValidEmail', 'username' => 'user2', 'plainPassword' => $matching), 'email', FailureListener::ERRORS[Email::class]),
            array(array('email' => 'example2@gmail.com', 'username' => 'user', 'plainPassword' => $matching), 'username', FailureListener::ERRORS[UniqueEntity::class]),
            array(array('email' => 'example@gmail.com', 'username' => 'user2', 'plainPassword' => $matching), 'email', FailureListener::ERRORS[UniqueEntity::class])
        );
    }

    /**
     * @throws \Exception
     */
    public function testValidForm()
    {
        $this->loadFixtures();

        $username = 'user';
        $email = 'example@gmail.com';
        $parameters = array('email' => $email, 'username' => $username, 'plainPassword' => self::MATCHING_PASSWORD);

        $client = $this->makeClient();
        $client->request('POST', '/security/registration/register', array('fos_user_registration_form' => $parameters));

        $this->assertStatusCode(200, $client);
        $this->assertJsonResponse($client);

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertCount(1, $content);

        $this->assertEquals(SuccessListener::SUCCESS_MESSAGE, $content['message']);

        $userList = $this->getRepository(User::REPOSITORY)->findAll();
        $this->assertCount(1, $userList);

        /** @var User $user */
        $user = $userList[0];
        $this->assertTrue($user->isEnabled());
        $this->assertEquals($email,    $user->getEmail());
        $this->assertEquals($username, $user->getUsername());
    }

}
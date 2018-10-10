<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 09:47
 */

namespace UserBundle\Tests\Functional\Profile;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;
use UserBundle\Entity\User;
use UserBundle\EventSubscriber\FormFailureListener;
use UserBundle\EventSubscriber\FormPostInitializeListener;
use UserBundle\EventSubscriber\Profile\ChangePassword\FailureListener;
use UserBundle\Fixtures\ORM\UserSingletonFixtures;

/**
 * @package UserBundle\Tests\Functional\Profile
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class ChangePasswordTest extends BaseProfileTest
{

    /** @var array */
    const MATCHING_PASSWORD = array('first' => 'newPassword', 'second' => 'newPassword');

    /** @var array */
    const INVALID_PASSWORD  = array('first' => 'newPassword', 'second' => 'newPassword2');

    /**
     * @dataProvider exceptionProvider
     * @param array $parameters
     * @throws \Exception
     */
    public function testThrowsException(array $parameters)
    {
        $fixtures = $this->loadFixtures(array(UserSingletonFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserSingletonFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri(), $parameters);

        $this->assertStatusCode(400, $client);
        $this->assertJsonResponse($client);

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('requirements', $content);
        $this->assertArrayHasKey('message', $content);
        $this->assertCount(2, $content);

        $this->assertEquals(FormPostInitializeListener::ERROR_MESSAGE, $content['message']);
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
        $fixtures = $this->loadFixtures(array(UserSingletonFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserSingletonFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri(), array('fos_user_change_password_form' => $parameters));

        $this->assertStatusCode(400, $client);
        $this->assertJsonResponse($client);

        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('message', $content);
        $this->assertArrayHasKey('errors', $content);
        $this->assertCount(2, $content);

        $this->assertArrayHasKey($key, $content['errors']);
        $this->assertCount(1, $content['errors']);

        $this->assertEquals(FormFailureListener::ERROR_MESSAGE, $content['message']);
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
            array(array('current_password' => 'changeme'),                                'newPassword', FailureListener::ERRORS[NotBlank::class]),
            array(array('current_password' => 'changeme2', 'plainPassword' => $matching), 'password',    FailureListener::ERRORS[UserPassword::class]),
            array(array('current_password' => 'changeme',  'plainPassword' => $invalid),  'newPassword', FailureListener::ERRORS[Form::class]),
        );
    }

    /**
     * @throws \Exception
     */
    public function testValidRequest()
    {
        $parameters = array('current_password' => 'changeme', 'plainPassword' => self::MATCHING_PASSWORD);
        $fixtures   = $this->loadFixtures(array(UserSingletonFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserSingletonFixtures::REFERENCE);
        $old  = $user->getPassword();

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri(), array('fos_user_change_password_form' => $parameters));

        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $entityManager->refresh($user);

        $new = $user->getPassword();
        $this->assertNotEquals($old, $new);
    }

    /**
     * {@inheritdoc}
     */
    protected function buildUri(): string
    {
        return '/security/profile/password';
    }

}
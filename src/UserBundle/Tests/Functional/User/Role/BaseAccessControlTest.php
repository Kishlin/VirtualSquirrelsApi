<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 16:42
 */

namespace UserBundle\Tests\Functional\User\Role;


use UserBundle\Entity\User;
use UserBundle\Fixtures\ORM\UserMemberFixtures;
use UserBundle\Fixtures\ORM\UserOfficerFixtures;
use UserBundle\Fixtures\ORM\UserSingletonFixtures;
use UserBundle\Tests\Functional\Util\WebTestCase;

/**
 * @package UserBundle\Tests\Functional\User\Role
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
abstract class BaseAccessControlTest extends WebTestCase
{

    /**
     * @throws \Exception
     */
    public function testNotLoggedIn()
    {
        $fixtures = $this->loadFixtures(array(UserMemberFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserMemberFixtures::REFERENCE);

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri($user->getId(), 'trial'));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @throws \Exception
     */
    public function testDoesNotHaveOfficerRole()
    {
        $fixtures = $this->loadFixtures(array(UserMemberFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserMemberFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri($user->getId(), 'trial'));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @throws \Exception
     */
    public function testNotFoundUser()
    {
        $fixtures = $this->loadFixtures(array(UserOfficerFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserOfficerFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri($user->getId() + 1, 'trial'));

        $this->assertErrorResponse($client, 404);
    }

    /**
     * @throws \Exception
     */
    public function testNotFoundRole()
    {
        $fixtures = $this->loadFixtures(array(UserOfficerFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserOfficerFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri($user->getId(), 'nonextant'));

        $this->assertErrorResponse($client, 404);
    }

    /**
     * @throws \Exception
     */
    public function testCannotUpdateSelf()
    {
        $fixtures = $this->loadFixtures(array(UserOfficerFixtures::class))->getReferenceRepository();

        /** @var User $user */
        $user = $fixtures->getReference(UserOfficerFixtures::REFERENCE);

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri($user->getId(), 'trial'));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @throws \Exception
     */
    public function testCannotTargetRoleAdmin()
    {
        $fixtures = $this->loadFixtures(array(UserOfficerFixtures::class, UserSingletonFixtures::class))->getReferenceRepository();

        $target = $fixtures->getReference(UserSingletonFixtures::REFERENCE); /** @var User $target */
        $user   = $fixtures->getReference(UserOfficerFixtures::REFERENCE);   /** @var User $user   */

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri($target->getId(), 'admin'));

        $this->assertErrorResponse($client, 403);
    }

    /**
     * @param int    $userId
     * @param string $role
     * @return string
     */
    abstract protected function buildUri(int $userId, string $role): string;

}
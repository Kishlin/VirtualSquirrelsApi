<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 15:28
 */

namespace UserBundle\Tests\Repository;


use Liip\FunctionalTestBundle\Test\WebTestCase;
use UserBundle\Entity\User;
use UserBundle\Fixtures\ORM\MultitonFixtures;
use UserBundle\Repository\UserRepository;
use UserBundle\UserRoles;


/**
 * @package UserBundle\Tests\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserRepositoryTest extends WebTestCase
{

    /** @var UserRepository */
    protected $repository;


    protected function setUp()
    {
        parent::setUp();

        $this->repository = $this->getContainer()->get('doctrine.orm.entity_manager')->getRepository(User::REPOSITORY);
    }

    /**
     * @dataProvider getFilteredListByRoleProvider
     * @param int    $count
     * @param string $role
     * @throws \Exception
     */
    public function testGetFilteredListByRole(int $count, string $role)
    {
        $this->loadFixtures(array(MultitonFixtures::class));

        $this->assertCount($count, $this->repository->findByRole($role, null));
    }

    /**
     * @return array
     */
    public function getFilteredListByRoleProvider(): array
    {
        return array(
            array(0, UserRoles::ROLE_OFFICER),
            array(1, UserRoles::ROLE_MEMBER),
            array(2, UserRoles::ROLE_TRIAL)
        );
    }

    /**
     * @throws \Exception
     */
    public function testGetFilteredListByRoleExclusion()
    {
        $references = $this->loadFixtures(array(MultitonFixtures::class))->getReferenceRepository();

        /** @var User $excluded */
        $excluded = $references->getReference(MultitonFixtures::REFERENCE);

        $this->assertEmpty($this->repository->findByRole(UserRoles::ROLE_MEMBER, $excluded));
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 17:05
 */

namespace UserBundle\Tests\Functional\User\Role;


use UserBundle\Entity\User;
use UserBundle\Fixtures\ORM\UserMemberFixtures;
use UserBundle\Fixtures\ORM\UserOfficerFixtures;
use UserBundle\Fixtures\ORM\UserTrialFixtures;
use UserBundle\UserRoles;


/**
 * @package UserBundle\Tests\Functional\User\Role
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class DemoteTest extends BaseAccessControlTest
{

    /**
     * @dataProvider provider
     * @param array  $fixtures
     * @param string $targetReference
     * @param string $role
     * @param string $expected
     * @throws \Exception
     */
    public function testPromote(array $fixtures, string $targetReference, string $role = 'member', string $expected = UserRoles::ROLE_MEMBER)
    {
        $references = $this->loadFixtures($fixtures)->getReferenceRepository();

        $user   = $references->getReference(UserOfficerFixtures::REFERENCE); /** @var User $user   */
        $target = $references->getReference($targetReference);               /** @var User $target */

        $this->loginAs($user, 'main');

        $client = $this->makeClient();
        $client->request('POST', $this->buildUri($target->getId(), $role));

        $this->assertFalse($target->hasRole($expected));
    }

    /**
     * @return array
     */
    public function provider(): array
    {
        return array(
            'without role' => array(array(UserOfficerFixtures::class, UserTrialFixtures::class),  UserTrialFixtures::REFERENCE),
            'with role'    => array(array(UserOfficerFixtures::class, UserMemberFixtures::class), UserMemberFixtures::REFERENCE)
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function buildUri(int $userId, string $role): string
    {
        return "/security/users/$userId/demote/$role";
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 16:58
 */

namespace Tests\Functional\User\Role;


use App\Entity\User;
use App\DataFixtures\ORM\User\UserMemberFixtures;
use App\DataFixtures\ORM\User\UserOfficerFixtures;
use App\DataFixtures\ORM\User\UserTrialFixtures;
use App\UserRoles;


/**
 * @package Tests\Functional\User\Role
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class PromoteTest extends BaseAccessControlTest
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

        $this->assertTrue($target->hasRole($expected));
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
        return "/security/users/$userId/promote/$role";
    }

}

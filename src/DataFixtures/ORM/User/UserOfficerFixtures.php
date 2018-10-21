<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 12:19
 */

namespace App\DataFixtures\ORM\User;


use Doctrine\Common\Persistence\ObjectManager;
use App\UserRoles;


/**
 * @package App\DataFixtures\ORM\User
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserOfficerFixtures extends UserFixtures
{

    /** @var string */
    const REFERENCE = 'user-officer';


    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $user = $this->factory->createUser('officer');

        $user->addRole(UserRoles::ROLE_TRIAL);
        $user->addRole(UserRoles::ROLE_MEMBER);
        $user->addRole(UserRoles::ROLE_OFFICER);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }

}

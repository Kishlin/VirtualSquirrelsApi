<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 16:27
 */

namespace UserBundle\Fixtures\Util\Factory;


use FOS\UserBundle\Util\PasswordUpdaterInterface;
use UserBundle\Entity\User;


/**
 * @package UserBundle\Tests\Util\Factory
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserFactory
{

    /** @var PasswordUpdaterInterface */
    protected $passwordUpdater;

    public function __construct(PasswordUpdaterInterface $passwordUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
    }


    /**
     * @param string   $userName
     * @param string[] $roles
     * @return User
     */
    public function createUser(string $userName, array $roles = array()): User
    {
        $user = new User();

        $user->setEnabled(true);
        $user->setUsername($userName);
        $user->setPlainPassword('changeme');
        $user->setEmail("$userName@gmail.com");

        $this->passwordUpdater->hashPassword($user);

        foreach ($roles as $role) $user->addRole($role);

        return $user;
    }

}
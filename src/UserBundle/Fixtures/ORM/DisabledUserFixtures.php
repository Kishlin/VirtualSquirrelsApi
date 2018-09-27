<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 16:08
 */

namespace UserBundle\Fixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Util\PasswordUpdaterInterface;
use UserBundle\Entity\User;

/**
 * @package UserBundle\Fixtures\ORM
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class DisabledUserFixtures extends Fixture
{

    /** @var PasswordUpdaterInterface */
    private $passwordUpdater;

    public function __construct(PasswordUpdaterInterface $passwordUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
    }


    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $user = new User();

        $user->setUsername('user');
        $user->setPlainPassword('changeme');
        $user->setEmail('example@gmail.com');

        $this->passwordUpdater->hashPassword($user);

        $manager->persist($user);
        $manager->flush();
    }

}
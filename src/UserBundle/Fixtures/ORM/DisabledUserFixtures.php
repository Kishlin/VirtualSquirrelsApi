<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 16:08
 */

namespace UserBundle\Fixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;

/**
 * @package UserBundle\Fixtures\ORM
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class DisabledUserFixtures extends UserFixtures
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $user = $this->factory->createUser('disabled');

        $user->setEnabled(false);

        $manager->persist($user);
        $manager->flush();
    }

}
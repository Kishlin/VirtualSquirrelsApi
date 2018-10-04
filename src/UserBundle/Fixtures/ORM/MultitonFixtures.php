<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 15:58
 */

namespace UserBundle\Fixtures\ORM;


use Doctrine\Common\Persistence\ObjectManager;
use UserBundle\UserRoles;


/**
 * @package UserBundle\Fixtures\ORM
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class MultitonFixtures extends UserFixtures
{

    /** @var string */
    const REFERENCE = 'user-member';


    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $member = $this->factory->createUser('member', array(UserRoles::ROLE_TRIAL, UserRoles::ROLE_MEMBER));
        $trial  = $this->factory->createUser('trial',  array(UserRoles::ROLE_TRIAL));

        $manager->persist($member);
        $manager->persist($trial);
        $manager->flush();

        $this->addReference(self::REFERENCE, $member);
    }

}
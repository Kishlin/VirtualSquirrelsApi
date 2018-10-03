<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 16:56
 */

namespace UserBundle\Fixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use UserBundle\Tests\Util\Factory\UserFactory;

/**
 * @package UserBundle\Fixtures\ORM
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
abstract class UserFixtures extends Fixture
{

    /** @var UserFactory */
    protected $factory;

    /**
     * @param UserFactory $factory
     */
    public function __construct(UserFactory $factory)
    {
        $this->factory = $factory;
    }

}
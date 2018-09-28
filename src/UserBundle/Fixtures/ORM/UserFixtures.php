<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 27/09/2018
 * Time: 16:56
 */

namespace UserBundle\Fixtures\ORM;


use Doctrine\Bundle\FixturesBundle\Fixture;
use FOS\UserBundle\Util\PasswordUpdaterInterface;

/**
 * @package UserBundle\Fixtures\ORM
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
abstract class UserFixtures extends Fixture
{

    /** @var PasswordUpdaterInterface */
    protected $passwordUpdater;

    public function __construct(PasswordUpdaterInterface $passwordUpdater)
    {
        $this->passwordUpdater = $passwordUpdater;
    }

}
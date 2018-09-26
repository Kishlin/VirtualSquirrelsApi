<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 16:41
 */

namespace UserBundle;


/**
 * @package UserBundle
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserRoles
{

    private function __construct() { }

    /** @var string */
    const ROLE_TRIAL = 'ROLE_TRIAL';

    /** @var string */
    const ROLE_MEMBER = 'ROLE_MEMBER';

    /** @var string */
    const ROLE_OFFICER = 'ROLE_OFFICER';

    /** @var string */
    const ROLE_ADMIN = 'ROLE_ADMIN';

}
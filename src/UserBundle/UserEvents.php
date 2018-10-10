<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 09:42
 */

namespace UserBundle;


/**
 * @package UserBundle
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
final class UserEvents
{

    private function __construct() { }


    /** @var string */
    const PROFILE_FORM_FAILURE_EVENT = 'profile.form.failure.event';

}

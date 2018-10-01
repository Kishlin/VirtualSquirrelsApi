<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/23/2018
 * Time: 6:34 PM
 */

namespace CoreBundle;

/**
 * @package CoreBundle
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class CoreEvents
{

    private function __construct() { }

    /** @var string */
    const API_LOGIN = 'core.api.login';

    /** @var string */
    const EVENT_PARTICIPATION_NEW = 'core.event.participation.new';

}
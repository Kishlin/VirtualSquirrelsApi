<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 01/10/2018
 * Time: 11:25
 */

namespace CoreBundle;


/**
 * @package CoreBundle
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
final class CoreEvents
{

    private function __construct() { }

    /** @var string */
    const EVENT_FORM_FAILURE = 'form.failure';

    /** @var string */
    const NOTIFICATION_NEW = 'notification.new';

}
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
    const API_LOGIN = 'core.api.login';

    /** @var string */
    const EVENT_FORM_FAILURE = 'form.failure';

    /** @var string */
    const EVENT_ENTITY_INITIALIZE = 'event.entity.initialize';

    /** @var string */
    const EVENT_FORCE_PARTICIPATION = 'event.force.participation.';

    /** @var string */
    const EVENT_FINALIZE_EVENT = 'event.add.participation.finalize';

    /** @var string */
    const EVENT_ADD_PARTICIPATION_INITIALIZE = 'event.add.participation.initialize';

    /** @var string */
    const EVENT_REMOVE_PARTICIPATION_INITIALIZE = 'event.remove.participation.initialize';

    /** @var string */
    const NOTIFICATION_NEW = 'notification.new';

}

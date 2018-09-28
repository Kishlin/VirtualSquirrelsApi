<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:01
 */

namespace CoreBundle\Enumerations;


/**
 * @package CoreBundle\Enumerations
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationType
{

    private function __construct() { }

    /** @var int */
    const TYPE_POSITIVE = 0;

    /** @var int */
    const TYPE_NEGATIVE = 1;

    /** @var int */
    const TYPE_UNSURE = 2;

}
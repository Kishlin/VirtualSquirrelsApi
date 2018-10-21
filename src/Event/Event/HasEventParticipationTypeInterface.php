<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:52
 */

namespace App\Event\Event;


/**
 * @package App\Event\Event\Model
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface HasEventParticipationTypeInterface
{

    /**
     * @return int
     */
    function getType(): int;

}

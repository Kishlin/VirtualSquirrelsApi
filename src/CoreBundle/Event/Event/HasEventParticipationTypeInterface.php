<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:52
 */

namespace CoreBundle\Event\Event;


use UserBundle\Event\UserEventInterface;

/**
 * @package CoreBundle\Event\Event\Model
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface HasEventParticipationTypeInterface extends HasEventInterface, UserEventInterface
{

    /**
     * @return int
     */
    function getType(): int;

}

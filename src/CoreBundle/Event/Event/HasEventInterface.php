<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:56
 */

namespace CoreBundle\Event\Event;


use CoreBundle\Entity\Event\Event;

/**
 * @package CoreBundle\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface HasEventInterface
{

    /**
     * @return Event
     */
    function getEvent(): Event;

}

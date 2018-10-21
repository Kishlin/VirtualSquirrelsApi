<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 3:20 PM
 */

namespace CoreBundle\Manager\Event;


use CoreBundle\Entity\Event\Event;

/**
 * @package CoreBundle\Manager\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
interface EntityManagerInterface
{

    /**
     * @param Event $event
     * @return Event
     */
    public function saveEvent(Event $event): Event;

    /**
     * @param Event $event
     * @return Event
     */
    public function removeEvent(Event $event): Event;

}
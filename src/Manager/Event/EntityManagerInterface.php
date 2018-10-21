<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 3:20 PM
 */

namespace App\Manager\Event;


use App\Entity\Event\Event;

/**
 * @package App\Manager\Event
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
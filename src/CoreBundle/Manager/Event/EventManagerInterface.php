<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:07
 */

namespace CoreBundle\Manager\Event;


use CoreBundle\Entity\Event\Event;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface EventManagerInterface
{

    /**
     * @param Event $event
     * @param User  $user
     * @return Event
     */
    function addPositiveParticipation(Event $event, User $user): Event;

    /**
     * @param Event $event
     * @param User  $user
     * @return Event
     */
    function addNegativeParticipation(Event $event, User $user): Event;

    /**
     * @param Event $event
     * @param User  $user
     * @return Event
     */
    function addUnsureParticipation(Event $event, User $user): Event;

}
<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 12:14 PM
 */

namespace CoreBundle\RequestHandler\Event;


use Symfony\Component\HttpFoundation\Response;
use CoreBundle\Entity\Event\Event;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\RequestHandler\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
interface EventParticipationHandlerInterface
{

    /**
     * @param Event $event
     * @param User  $user
     * @param int   $type
     * @return Response
     */
    public function add(Event $event, User $user, int $type): Response;

    /**
     * @param Event $event
     * @param User  $user
     * @return Response
     */
    public function remove(Event $event, User $user): Response;

}

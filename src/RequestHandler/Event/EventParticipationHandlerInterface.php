<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 12:14 PM
 */

namespace App\RequestHandler\Event;


use Symfony\Component\HttpFoundation\Response;
use App\Entity\Event\Event;
use App\Entity\User;

/**
 * @package App\RequestHandler\Event
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

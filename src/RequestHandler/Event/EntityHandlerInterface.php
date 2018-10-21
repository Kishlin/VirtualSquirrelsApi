<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 2:55 PM
 */

namespace App\RequestHandler\Event;


use App\Entity\Event\Event;
use App\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

/**
 * @package App\RequestHandler\Event
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link https://pierrelouislegrand.fr
 */
interface EntityHandlerInterface
{

    /**
     * @param Request    $request
     * @param Event|null $event
     * @param User       $requestingUser
     * @return Response
     * @throws BadRequestException
     */
    public function handleEventForm(Request $request, User $requestingUser, ?Event $event): Response;

}
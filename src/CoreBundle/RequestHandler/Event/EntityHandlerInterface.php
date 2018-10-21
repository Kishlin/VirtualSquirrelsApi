<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 2:55 PM
 */

namespace CoreBundle\RequestHandler\Event;


use CoreBundle\Entity\Event\Event;
use CoreBundle\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\RequestHandler\Event
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
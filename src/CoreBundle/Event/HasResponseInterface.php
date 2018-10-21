<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 06/10/2018
 * Time: 12:55
 */

namespace CoreBundle\Event;


use Symfony\Component\HttpFoundation\Response;

/**
 * @package CoreBundle\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface HasResponseInterface
{

    /**
     * @return Response
     */
    function getResponse(): Response;

    /**
     * @param Response $response
     */
    function setResponse(Response $response): void;

}
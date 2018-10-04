<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 16:02
 */

namespace CoreBundle\Event\Event;


use Symfony\Component\HttpFoundation\Response;

/**
 * @package CoreBundle\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface HasResponseInterface extends HasEventInterface
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
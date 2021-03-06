<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 19:05
 */

namespace App\Event\Event;


use App\Event\HasResponseInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package App\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventFinalizeEvent extends BaseUserEvent implements HasResponseInterface
{

    /** @var Response */
    protected $response;


    /**
     * {@inheritdoc}
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * {@inheritdoc}
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

}
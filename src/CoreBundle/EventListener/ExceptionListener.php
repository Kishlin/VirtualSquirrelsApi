<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 6:46 PM
 */

namespace CoreBundle\EventListener;


use CoreBundle\Services\HttpFoundation\ExceptionResponseBuilderInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * @package CoreBundle\EventListener
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class ExceptionListener
{

    /** @var ExceptionResponseBuilderInterface */
    protected $exceptionResponseBuilder;

    /**
     * @param ExceptionResponseBuilderInterface $exceptionResponseBuilder
     */
    public function __construct(ExceptionResponseBuilderInterface $exceptionResponseBuilder)
    {
        $this->exceptionResponseBuilder = $exceptionResponseBuilder;
    }


    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response  = $this->exceptionResponseBuilder->build($exception);

        $event->setResponse($response);
    }

}
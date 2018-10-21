<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 6:46 PM
 */

namespace CoreBundle\EventListener;


use CoreBundle\Services\HttpFoundation\ExceptionResponseBuilderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * @package CoreBundle\EventListener
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class ExceptionListener
{

    /** @var ExceptionResponseBuilderInterface */
    protected $exceptionResponseBuilder;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param ExceptionResponseBuilderInterface $exceptionResponseBuilder
     * @param LoggerInterface                   $logger
     */
    public function __construct(ExceptionResponseBuilderInterface $exceptionResponseBuilder, LoggerInterface $logger)
    {
        $this->exceptionResponseBuilder = $exceptionResponseBuilder;
        $this->logger = $logger;
    }


    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response  = $this->exceptionResponseBuilder->build($exception);

        $event->setResponse($response);

        while($exception !== null) {
            $this->logger->error('Exception occurred in kernel.', array(
                'message' => $exception->getMessage(),
                'trace'   => $exception->getTraceAsString(),
                'method'  => 'onKernelException',
                'class'   => self::class
            ));

            $exception = $exception->getPrevious();
        }
    }

}
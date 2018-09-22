<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 6:46 PM
 */

namespace CoreBundle\Listener;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;


/**
 * Class ExceptionListener
 */
class ExceptionListener
{

    const MESSAGE = 'An exception occurred in kernel.';

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        $this->logger->error(self::MESSAGE, array(
            'message' => $exception->getMessage(),
            'trace'   => $exception->getTraceAsString()
        ));

        $event->setResponse(new JsonResponse(array('message' => self::MESSAGE), 500));
    }

}
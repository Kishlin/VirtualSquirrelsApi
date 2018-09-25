<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 6:46 PM
 */

namespace CoreBundle\EventListener;

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

    /** @var string */
    protected $env;

    /**
     * @param LoggerInterface $logger
     * @param string          $env
     */
    public function __construct(LoggerInterface $logger, string $env)
    {
        $this->logger = $logger;
        $this->env    = $env;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $array = array('message' => self::MESSAGE);

        $this->logger->error(self::MESSAGE, array(
            'class'   => get_class($exception),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
            'message' => $exception->getMessage(),
            'trace'   => $exception->getTraceAsString()
        ));

        if ($this->env !== 'prod') {
            $array['exception']['message'] = $exception->getMessage();
            $array['exception']['file']    = $exception->getFile();
            $array['exception']['line']    = $exception->getLine();
            $array['exception']['trace']   = $exception->getTraceAsString();
        }

        $event->setResponse(new JsonResponse($array, 500));
    }

}
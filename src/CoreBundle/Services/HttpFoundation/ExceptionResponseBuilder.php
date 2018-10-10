<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 10:50
 */

namespace CoreBundle\Services\HttpFoundation;


use Monolog\Logger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * @package CoreBundle\Services\HttpFoundation
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class ExceptionResponseBuilder implements ExceptionResponseBuilderInterface
{

    /** @var Logger Logger */
    protected $logger;

    /** @var string */
    protected $env;

    /**
     * @param Logger $logger
     * @param string $env
     */
    public function __construct(Logger $logger, string $env)
    {
        $this->logger = $logger;
        $this->env    = $env;
    }


    /**
     * {@inheritdoc}
     */
    public function build(\Exception $exception): JsonResponse
    {
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

        $code = $this->getStatusCode($exception);

        return new JsonResponse($array, $code);
    }

    /**
     * @param \Exception $e
     * @return int
     */
    protected function getStatusCode(\Exception $e): int
    {
        if ($e instanceof AccessDeniedException)
            return 403;

        if ($e instanceof NotFoundHttpException)
            return 404;

        return 500;
    }

}

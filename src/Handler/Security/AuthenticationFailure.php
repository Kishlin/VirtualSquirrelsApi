<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 10:46
 */

namespace App\Handler\Security;


use App\Services\HttpFoundation\ExceptionResponseBuilderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;

/**
 * @package App\Services\Security
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AuthenticationFailure implements AuthenticationFailureHandlerInterface
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
     * {@inheritdoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        return $this->exceptionResponseBuilder->build($exception);
    }

}
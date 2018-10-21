<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 11:11
 */

namespace App\Handler\Security;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @package App\Handler\Security
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AuthenticationSuccess implements AuthenticationSuccessHandlerInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var RouterInterface */
    protected $router;

    /** @var string */
    protected $loginRedirect;

    /**
     * @param LoggerInterface $logger
     * @param RouterInterface $router
     * @param string          $loginRedirect
     */
    public function __construct(LoggerInterface $logger, RouterInterface $router, string $loginRedirect)
    {
        $this->logger = $logger;
        $this->router = $router;

        $this->loginRedirect = $loginRedirect;
    }


    /**
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $token = $event->getAuthenticationToken();
        $request = $event->getRequest();

        $this->onAuthenticationSuccess($request, $token);
    }

    /**
     * {@inheritdoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $route = $this->router->generate($this->loginRedirect);
        return new RedirectResponse($route, 303);
    }


}
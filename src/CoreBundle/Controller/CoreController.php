<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/23/2018
 * Time: 6:03 PM
 */

namespace CoreBundle\Controller;

use CoreBundle\CoreEvents;
use CoreBundle\Event\LoginEvent;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class CoreController
 */
class CoreController extends Controller
{

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    /** @var TokenStorageInterface */
    private $tokenStorage;

    /**
     * CoreController constructor.
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, TokenStorageInterface $tokenStorage)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->tokenStorage    = $tokenStorage;
    }


    /**
     * @param Request              $request
     * @param UserManagerInterface $userManager
     *
     * @return JsonResponse
     */
    public function authAction(Request $request, UserManagerInterface $userManager): JsonResponse
    {
        if ($this->getUser() !== null) throw new BadRequestHttpException();

        $user = $userManager->findUserByEmail($request->request->get('email'));

        if ($user === null) throw new BadRequestHttpException();

        $event = new LoginEvent($user, $request);
        $this->eventDispatcher->dispatch(CoreEvents::API_LOGIN, $event);

        if ($user === $this->getUser()) throw new \RuntimeException();

        return new JsonResponse(array('success' => 'ok', 'user' => $user->getEmail()));
    }

    /**
     * @return JsonResponse
     */
    public function whoAmIAction(): JsonResponse
    {
        if (null === ($user = $this->getUser())) throw new \RuntimeException('User is not authenticated.');

        return new JsonResponse(array('user' => $user->getEmail()));
    }

    /**
     * @return JsonResponse
     */
    public function logoutAction(): JsonResponse
    {
        $this->tokenStorage->setToken(null);

        return new JsonResponse(array('success' => 'ok'));
    }


}
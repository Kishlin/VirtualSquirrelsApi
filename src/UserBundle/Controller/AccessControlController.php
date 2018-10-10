<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 12:44
 */

namespace UserBundle\Controller;


use CoreBundle\Exception\LogicException;
use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;
use UserBundle\Event\RoleEditEvent;
use UserBundle\Manager\UserManagerInterface;
use UserBundle\UserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @package UserBundle\Controller
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AccessControlController extends Controller
{

    /** @var string */
    const ACTION_PROMOTE = 'promote';

    /** @var string */
    const ACTION_DEMOTE = 'demote';


    /** @var UserManagerInterface */
    protected $userManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @param UserManagerInterface     $userManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(UserManagerInterface $userManager, EventDispatcherInterface $eventDispatcher)
    {
        $this->userManager     = $userManager;
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * @ParamConverter("user",  options={"mapping"={"userId"="id"}})
     *
     * @param User    $user
     * @param string  $role
     * @return Response
     * @throws LogicException
     */
    public function promoteAction(User $user, string $role): Response
    {
        $action = self::ACTION_PROMOTE;

        return $this->doChangeUserRole($user, $role, $action);
    }

    /**
     * @ParamConverter("user",  options={"mapping"={"userId"="id"}})
     *
     * @param User    $user
     * @param string  $role
     * @return Response
     * @throws LogicException
     */
    public function demoteAction(User $user, string $role): Response
    {
        $action = self::ACTION_DEMOTE;

        return $this->doChangeUserRole($user, $role, $action);
    }

    /**
     * @param User    $user
     * @param string  $role
     * @param string  $action
     * @return Response
     * @throws LogicException
     */
    protected function doChangeUserRole(User $user, string $role, string $action): Response
    {
        $role = strtoupper("ROLE_$role");

        $roleEvent = new RoleEditEvent($user, $role);
        $this->eventDispatcher->dispatch(UserEvents::ROLE_EDIT_EVENT, $roleEvent);

        switch ($action) {
            case self::ACTION_PROMOTE:
                $this->userManager->promote($user, $role);
                break;
            case self::ACTION_DEMOTE:
                $this->userManager->demote($user, $role);
                break;
            default:
                throw new LogicException('Statement should not be reached.');
        }

        $finalizeEvent = new GetResponseUserEvent($user);
        $this->eventDispatcher->dispatch(UserEvents::USER_CHANGED_FINALIZE, $finalizeEvent);

        if (null === $response = $finalizeEvent->getResponse()) {
            throw new LogicException('Finalize event should have a response.');
        }

        return $response;
    }

}

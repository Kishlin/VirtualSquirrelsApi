<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 16:25
 */

namespace App\EventSubscriber\User\AccessControl;


use App\Exception\AccessDeniedException;
use App\Exception\BadRequestException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\User;
use App\Event\RoleEditEvent;
use App\UserEvents;
use App\UserRoles;

/**
 * @package App\App\EventSubscriber\User\AccessControl
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RoleEditListener implements EventSubscriberInterface
{

    /** @var string */
    const NONEXTANT_ROLE = 'This role does not exist.';

    /** @var string */
    const ADMIN_ROLE = 'Cannot target admin role.';

    /** @var string */
    const SELF = 'Cannot target self.';


    /** @var LoggerInterface */
    protected $logger;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /**
     * @param LoggerInterface       $logger
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(LoggerInterface $logger, TokenStorageInterface $tokenStorage)
    {
        $this->logger       = $logger;
        $this->tokenStorage = $tokenStorage;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::ROLE_EDIT_EVENT => 'checkRoleConsistency'
        );
    }

    /**
     * @param RoleEditEvent $roleEditEvent
     * @throws BadRequestException
     */
    public function checkRoleConsistency(RoleEditEvent $roleEditEvent)
    {
        $target = $roleEditEvent->getUser();
        $role   = $roleEditEvent->getRole();

        if (!in_array($role, User::getPossibleRoles())) {
            $this->logger->warning('Request on a nonextant role.', array('role' => $role, 'method' => 'checkRoleConsistency', 'class' => self::class));

            throw new NotFoundHttpException(self::NONEXTANT_ROLE);
        }

        if ($role === UserRoles::ROLE_ADMIN) {
            $this->logger->warning('Request on admin role.', array('role' => $role, 'method' => 'checkRoleConsistency', 'class' => self::class));

            throw new AccessDeniedException(self::ADMIN_ROLE);
        }

        /** @var User $currentUser */
        $currentUser = $this->tokenStorage->getToken()->getUser();

        if ($currentUser === $target) {
            $this->logger->warning('Request on self.', array('role' => $role, 'method' => 'checkRoleConsistency', 'class' => self::class));

            throw new AccessDeniedException(self::SELF);
        }

        if (!($currentUser instanceof User)) {
            $this->logger->warning('User is not logged in.', array('role' => $role, 'method' => 'checkRoleConsistency', 'class' => self::class));

            throw new AccessDeniedException();
        }
    }

}
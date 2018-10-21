<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 15:03
 */

namespace App\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use App\Entity\User;
use App\Repository\UserRepository;

/**
 * @package App\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserManager implements UserManagerInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var ObjectManager */
    protected $objectManager;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /**
     * @param LoggerInterface       $logger
     * @param ObjectManager         $objectManager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(LoggerInterface $logger, ObjectManager $objectManager, TokenStorageInterface $tokenStorage)
    {
        $this->logger        = $logger;
        $this->objectManager = $objectManager;
        $this->tokenStorage  = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function promote(User $user, string $role): User
    {
        if (!$user->hasRole($role)) {
            $user->addRole($role);

            $this->logger->info('Promoting user.', array(
                'user' => $user->getId(),
                'role' => $role,
                'method' => 'promote',
                'class' => self::class
            ));
        }

        return $this->flushAndReturnUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function demote(User $user, string $role): User
    {
        if ($user->hasRole($role)) {
            $user->removeRole($role);

            $this->logger->info('Demoting user.', array(
                'user' => $user->getId(),
                'role' => $role,
                'method' => 'promote',
                'class' => self::class
            ));
        }

        return $this->flushAndReturnUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function getFilteredListForRole(string $role, bool $withCurrent = true): array
    {
        $excluded = null;

        if (!$withCurrent) {
            /** @var User $excluded */
            $excluded = $this->tokenStorage->getToken()->getUser();
        }

        /** @var UserRepository $repository */
        $repository = $this->objectManager->getRepository(User::REPOSITORY);
        return $repository->findByRole($role, $excluded);
    }

    /**
     * @param User $user
     * @return User
     */
    protected function flushAndReturnUser(User $user): User
    {
        $objectManager = $this->objectManager;

        if (!$objectManager->contains($user))
            $objectManager->persist($user);

        $objectManager->flush();

        $objectManager->refresh($user);

        return $user;
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 15:03
 */

namespace UserBundle\Manager;


use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\User;
use UserBundle\Repository\UserRepository;


/**
 * @package UserBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserManager implements UserManagerInterface
{

    /** @var UserRepository */
    protected $repository;

    /** @var TokenStorageInterface */
    protected $tokenStorage;

    /**
     * @param ObjectManager         $objectManager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(ObjectManager $objectManager, TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

        $this->repository   = $objectManager->getRepository(User::REPOSITORY);
    }


    /**
     * {@inheritdoc}
     */
    public function getFilteredListForRole(string $role, bool $withCurrent = true): array
    {
        $excluded = null;

        if (!$withCurrent)
            /** @var User $excluded */
            $excluded = $this->tokenStorage->getToken()->getUser();

        return $this->repository->findByRole($role, $excluded);
    }

}
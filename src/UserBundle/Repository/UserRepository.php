<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 15:03
 */

namespace UserBundle\Repository;


use Doctrine\ORM\EntityRepository;
use UserBundle\Entity\User;

/**
 * @package UserBundle\Repository
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserRepository extends EntityRepository
{

    /**
     * @param string    $role
     * @param null|User $excluded
     * @return User[]
     */
    public function findByRole(string $role, ?User $excluded): array
    {
        $qb = $this->createQueryBuilder('u');

        if (null !== $excluded) $qb->andWhere($qb->expr()->neq('u.id', $excluded->getId()));

        return $qb
            ->andWhere($qb->expr()->like('u.roles', $qb->expr()->literal("%$role%")))
            ->getQuery()
            ->getResult()
        ;
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/01/2018
 * Time: 5:43 PM
 */

namespace CoreBundle\Repository\Notification;


use CoreBundle\Entity\Notification\NotificationType;

/**
 * @package CoreBundle\Repository
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationTypeRepository extends \Doctrine\ORM\EntityRepository
{

    /**
     * @param string $type
     * @return NotificationType|null
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByType(string $type): ?NotificationType
    {
        return $this->createQueryBuilder('notificationType')
            ->where('notificationType.type = :type')
            ->setParameter('type', $type)
            ->getQuery()
            ->getSingleResult()
        ;
    }

}

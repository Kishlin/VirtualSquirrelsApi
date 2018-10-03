<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 3:42 PM
 */

namespace UserBundle\Entity;


use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use CoreBundle\Entity\NotificationToUser;
use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\UserRoles;

/**
 * @ORM\Table(name="vs_user")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\UserRepository")
 *
 * @JMS\ExclusionPolicy("all")
 */
class User extends BaseUser
{

    /** @var string */
    const REPOSITORY = 'UserBundle:User';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\NotificationToUser", mappedBy="user", cascade={"remove"})
     */
    private $notificationToUserList;


    /**
     * @param NotificationToUser $notificationToUserList
     *
     * @return User
     */
    public function addNotificationToUserList(NotificationToUser $notificationToUserList): User
    {
        $this->notificationToUserList[] = $notificationToUserList;

        return $this;
    }

    /**
     * @param NotificationToUser $notificationToUserList
     *
     * @return User
     */
    public function removeNotificationToUserList(NotificationToUser $notificationToUserList): User
    {
        $this->notificationToUserList->removeElement($notificationToUserList);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getNotificationToUserList(): Collection
    {
        return $this->notificationToUserList;
    }


    /**
     * @return array
     */
    public static function getPossibleRoles(): array
    {
        return array(
            UserRoles::ROLE_TRIAL,
            UserRoles::ROLE_MEMBER,
            UserRoles::ROLE_OFFICER,
            UserRoles::ROLE_ADMIN
        );
    }

}

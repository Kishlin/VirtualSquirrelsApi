<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 3:42 PM
 */

namespace UserBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use CoreBundle\Entity\Event\EventParticipation;
use CoreBundle\Entity\Notification\NotificationToUser;
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

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Event\EventParticipation", mappedBy="participant", cascade={"remove"})
     */
    private $eventParticipationList;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="CoreBundle\Entity\Notification\NotificationToUser", mappedBy="user", cascade={"remove"})
     */
    private $notificationToUserList;

    public function __construct()
    {
        parent::__construct();

        $this->eventParticipationList = new ArrayCollection();
    }


    /**
     * @param EventParticipation $eventParticipationList
     *
     * @return User
     */
    public function addEventParticipationList(EventParticipation $eventParticipationList): User
    {
        $this->eventParticipationList[] = $eventParticipationList;

        return $this;
    }

    /**
     * @param EventParticipation $eventParticipationList
     *
     * @return User
     */
    public function removeEventParticipationList(EventParticipation $eventParticipationList): User
    {
        $this->eventParticipationList->removeElement($eventParticipationList);

        return $this;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEventParticipationList(): Collection
    {
        return $this->eventParticipationList;
    }

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

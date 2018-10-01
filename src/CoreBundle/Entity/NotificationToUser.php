<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/01/2018
 * Time: 5:43 PM
 */

namespace CoreBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * @ORM\Table(name="vs_notification_to_user")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\NotificationToUserRepository")
 *
 * @package CoreBundle\Entity
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationToUser
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="seen", type="boolean")
     */
    private $seen;

    /**
     * @var Notification
     *
     * @ORM\ManyToOne(targetEntity="Notification", inversedBy="notificationToUserList")
     * @ORM\JoinColumn(name="notificationId", referencedColumnName="id", nullable=false)
     */
    private $notification;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="notificationToUserList")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=false)
     */
    private $user;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param boolean $seen
     *
     * @return NotificationToUser
     */
    public function setSeen($seen): NotificationToUser
    {
        $this->seen = $seen;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSeen(): bool
    {
        return $this->seen;
    }

    /**
     * @param Notification $notification
     *
     * @return NotificationToUser
     */
    public function setNotification(Notification $notification): NotificationToUser
    {
        $this->notification = $notification;

        return $this;
    }

    /**
     * @return Notification
     */
    public function getNotification(): Notification
    {
        return $this->notification;
    }

    /**
     * @param User $user
     *
     * @return NotificationToUser
     */
    public function setUser(User $user): NotificationToUser
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

}

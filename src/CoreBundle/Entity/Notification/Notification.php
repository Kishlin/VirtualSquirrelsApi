<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/01/2018
 * Time: 5:43 PM
 */

namespace CoreBundle\Entity\Notification;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vs_notification")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Notification\NotificationRepository")
 *
 * @package CoreBundle\Entity
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class Notification
{

    /** @var string */
    const REPOSITORY = 'CoreBundle:Notification';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=4000)
     */
    private $message;

    /**
     * @var int
     *
     * @ORM\Column(name="target", type="integer", nullable=true)
     */
    private $targetId;

    /**
     * @var NotificationType
     *
     * @ORM\ManyToOne(targetEntity="NotificationType", inversedBy="notificationList")
     * @ORM\JoinColumn(name="notificationTypeId", referencedColumnName="id", nullable=false)
     */
    private $notificationType;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="NotificationToUser", mappedBy="notification", cascade={"remove"})
     */
    private $notificationToUserList;

    public function __construct()
    {
        $this->notificationToUserList = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param \DateTime $date
     *
     * @return Notification
     */
    public function setDate($date): Notification
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param string $subject
     *
     * @return Notification
     */
    public function setSubject($subject): Notification
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $message
     *
     * @return Notification
     */
    public function setMessage($message): Notification
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param integer $targetId
     *
     * @return Notification
     */
    public function setTargetId($targetId): Notification
    {
        $this->targetId = $targetId;

        return $this;
    }

    /**
     * @return integer
     */
    public function getTargetId(): int
    {
        return $this->targetId;
    }

    /**
     * @param NotificationType $notificationType
     *
     * @return Notification
     */
    public function setNotificationType(NotificationType $notificationType): Notification
    {
        $this->notificationType = $notificationType;

        return $this;
    }

    /**
     * @return NotificationType
     */
    public function getNotificationType(): NotificationType
    {
        return $this->notificationType;
    }

    /**
     * @param NotificationToUser $notificationToUserList
     *
     * @return Notification
     */
    public function addNotificationToUserList(NotificationToUser $notificationToUserList): Notification
    {
        $this->notificationToUserList[] = $notificationToUserList;

        return $this;
    }

    /**
     * @param NotificationToUser $notificationToUserList
     *
     * @return Notification
     */
    public function removeNotificationToUserList(NotificationToUser $notificationToUserList): Notification
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

}

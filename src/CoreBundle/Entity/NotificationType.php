<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/01/2018
 * Time: 5:43 PM
 */

namespace CoreBundle\Entity;


use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vs_notification_type")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\NotificationTypeRepository")
 *
 * @package CoreBundle\Entity
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NotificationType
{

    /** @var string */
    const REPOSITORY = 'CoreBundle:NotificationType';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Notification", mappedBy="notificationType", cascade={"remove"})
     */
    private $notificationList;

    public function __construct()
    {
        $this->notificationList = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $label
     *
     * @return NotificationType
     */
    public function setLabel($label): NotificationType
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param Notification $notificationList
     *
     * @return NotificationType
     */
    public function addNotificationList(Notification $notificationList): NotificationType
    {
        $this->notificationList[] = $notificationList;

        return $this;
    }

    /**
     * @param Notification $notificationList
     *
     * @return NotificationType
     */
    public function removeNotificationList(Notification $notificationList): NotificationType
    {
        $this->notificationList->removeElement($notificationList);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getNotificationList(): Collection
    {
        return $this->notificationList;
    }

}

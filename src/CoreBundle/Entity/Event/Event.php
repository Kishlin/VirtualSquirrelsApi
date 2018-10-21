<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 11:50
 */

namespace CoreBundle\Entity\Event;


use Symfony\Component\Validator\Constraints as Validation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="vs_event")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Event\EventRepository")
 */
class Event
{

    /** @var string */
    const DATE_FORMAT = 'Y-m-d H:i:s';

    /** @var string */
    const DATE_FORM_FORMAT = 'yyyy-MM-dd HH:mm:ss';

    /** @var string */
    const REPOSITORY = 'CoreBundle:Event\Event';

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
     * @ORM\Column(name="name", type="string", length=255)
     *
     * @Validation\NotBlank()
     * @Validation\Length(
     *     min = 3,
     *     max = 50
     * )
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="datetime")
     *
     * @Validation\NotBlank()
     * @Validation\DateTime()
     * @Validation\GreaterThanOrEqual(
     *     "today"
     * )
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="endDate", type="datetime")
     *
     * @Validation\NotBlank()
     * @Validation\DateTime()
     * @Validation\GreaterThanOrEqual(
     *     "today"
     * )
     * @Validation\Expression(
     *     "this.getStartDate() < this.getEndDate()"
     * )
     */
    private $endDate;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="EventParticipation", mappedBy="event", cascade={"remove"})
     */
    private $eventParticipationList;

    public function __construct()
    {
        $this->eventParticipationList = new ArrayCollection();
    }


    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return Event
     */
    public function setName($name): Event
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param \DateTime $startDate
     *
     * @return Event
     */
    public function setStartDate($startDate): Event
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    /**
     * @param \DateTime $endDate
     *
     * @return Event
     */
    public function setEndDate($endDate): Event
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    /**
     * @param EventParticipation $eventParticipationList
     *
     * @return Event
     */
    public function addEventParticipationList(EventParticipation $eventParticipationList): Event
    {
        $this->eventParticipationList[] = $eventParticipationList;

        return $this;
    }

    /**
     * @param EventParticipation $eventParticipationList
     *
     * @return Event
     */
    public function removeEventParticipationList(EventParticipation $eventParticipationList): Event
    {
        $this->eventParticipationList->removeElement($eventParticipationList);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getEventParticipationList(): Collection
    {
        return $this->eventParticipationList;
    }
}

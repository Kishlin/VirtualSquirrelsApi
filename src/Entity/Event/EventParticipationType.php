<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 12:23
 */

namespace App\Entity\Event;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * EventParticipationType
 *
 * @ORM\Table(name="vs_event_participation_type")
 * @ORM\Entity(repositoryClass="App\Repository\Event\EventParticipationTypeRepository")
 */
class EventParticipationType
{

    /** @var string */
    const REPOSITORY = 'App:Event\EventParticipationType';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer", unique=true)
     */
    private $type;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="EventParticipation", mappedBy="eventParticipationType", cascade={"remove"})
     */
    private $eventParticipationList;

    public function __construct()
    {
        $this->eventParticipationList = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param integer $type
     *
     * @return EventParticipationType
     */
    public function setType($type): EventParticipationType
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return integer
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @param EventParticipation $eventParticipationList
     *
     * @return EventParticipationType
     */
    public function addEventParticipationList(EventParticipation $eventParticipationList): EventParticipationType
    {
        $this->eventParticipationList[] = $eventParticipationList;

        return $this;
    }

    /**
     * @param EventParticipation $eventParticipationList
     *
     * @return EventParticipationType
     */
    public function removeEventParticipationList(EventParticipation $eventParticipationList): EventParticipationType
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

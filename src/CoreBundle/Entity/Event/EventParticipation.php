<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 12:23
 */

namespace CoreBundle\Entity\Event;


use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * EventParticipation
 *
 * @ORM\Table(name="vs_event_participation", uniqueConstraints={@ORM\UniqueConstraint(name="participation", columns={"eventId", "userId"})})
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\Event\EventParticipationRepository")
 */
class EventParticipation
{

    /** @var string */
    const REPOSITORY = 'CoreBundle:Event\EventParticipation';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Event
     *
     * @ORM\ManyToOne(targetEntity="Event", inversedBy="eventParticipationList")
     * @ORM\JoinColumn(name="eventId", referencedColumnName="id", nullable=false)
     */
    private $event;

    /**
     * @var EventParticipationType
     *
     * @ORM\ManyToOne(targetEntity="EventParticipationType", inversedBy="eventParticipationList")
     * @ORM\JoinColumn(name="eventParticipationTypeId", referencedColumnName="id", nullable=false)
     */
    private $eventParticipationType;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="eventParticipationList")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id", nullable=false)
     */
    private $participant;


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param Event $event
     *
     * @return EventParticipation
     */
    public function setEvent(Event $event): EventParticipation
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return Event
     */
    public function getEvent(): Event
    {
        return $this->event;
    }

    /**
     * @param EventParticipationType $eventParticipationType
     *
     * @return EventParticipation
     */
    public function setEventParticipationType(EventParticipationType $eventParticipationType): EventParticipation
    {
        $this->eventParticipationType = $eventParticipationType;

        return $this;
    }

    /**
     * @return EventParticipationType
     */
    public function getEventParticipationType(): EventParticipationType
    {
        return $this->eventParticipationType;
    }

    /**
     * @param User $participant
     *
     * @return EventParticipation
     */
    public function setParticipant(User $participant): EventParticipation
    {
        $this->participant = $participant;

        return $this;
    }

    /**
     * @return User
     */
    public function getParticipant(): User
    {
        return $this->participant;
    }

}

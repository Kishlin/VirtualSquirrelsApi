<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:23
 */

namespace CoreBundle\View\Event;


use JMS\Serializer\Annotation as JMS;

/**
 * @package CoreBundle\View\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 *
 * @JMS\ExclusionPolicy("all")
 */
class EventView
{

    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $id;

    /**
     * @var string
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $name;

    /**
     * @var \DateTime
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $startDate;

    /**
     * @var \DateTime
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $endDate;

    /**
     * @var EventAnswerListView
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $answers;

    /**
     * @param int                 $id
     * @param string              $name
     * @param \DateTime           $startDate
     * @param \DateTime           $endDate
     * @param EventAnswerListView $answers
     */
    public function __construct(int $id, string $name, \DateTime $startDate, \DateTime $endDate, EventAnswerListView $answers)
    {
        $this->id        = $id;
        $this->name      = $name;
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
        $this->answers   = $answers;
    }

}
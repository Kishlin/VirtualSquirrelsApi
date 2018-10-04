<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:25
 */

namespace CoreBundle\View\Event;


use JMS\Serializer\Annotation as JMS;

/**
 * @package CoreBundle\View\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 *
 * @JMS\ExclusionPolicy("all")
 */
class EventAnswerListView
{

    /**
     * @var EventAnswerView[]
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $positive;

    /**
     * @var EventAnswerView[]
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $unsure;

    /**
     * @var EventAnswerView[]
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $negative;

    /**
     * @var EventAnswerView[]
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $backup;

    /**
     * @param EventAnswerView[] $positive
     * @param EventAnswerView[] $unsure
     * @param EventAnswerView[] $negative
     * @param EventAnswerView[] $backup
     */
    public function __construct(array $positive, array $unsure, array $negative, array $backup)
    {
        $this->positive = $positive;
        $this->unsure   = $unsure;
        $this->negative = $negative;
        $this->backup   = $backup;
    }

}
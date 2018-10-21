<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:25
 */

namespace App\View\Event;


use JMS\Serializer\Annotation as JMS;

/**
 * @package App\View\Event
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
    protected $negative;

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
    protected $backup;

    /**
     * @param EventAnswerView[] $positive
     * @param EventAnswerView[] $negative
     * @param EventAnswerView[] $unsure
     * @param EventAnswerView[] $backup
     */
    public function __construct(array $positive, array $negative, array $unsure, array $backup)
    {
        $this->positive = $positive;
        $this->unsure   = $unsure;
        $this->negative = $negative;
        $this->backup   = $backup;
    }

}
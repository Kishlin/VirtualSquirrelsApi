<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:27
 */

namespace CoreBundle\View\Event;


use JMS\Serializer\Annotation as JMS;

/**
 * @package CoreBundle\View\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 *
 * @JMS\ExclusionPolicy("all")
 */
class EventAnswerView
{

    /**
     * @var int
     *
     * @JMS\Expose
     * @JMS\Groups({"default"})
     */
    protected $id;

    /**
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

}
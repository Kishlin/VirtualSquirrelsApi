<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 10:26
 */

namespace CoreBundle\Fixtures\Util\Factory\Event;


use CoreBundle\Entity\Event\Event;

/**
 * @package CoreBundle\Fixtures\Util\Factory\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventFactory
{

    /**
     * @param string    $name
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @return Event
     */
    public function newEvent(string $name, \DateTime $startDate, \DateTime $endDate): Event
    {
        return (new Event())
            ->setName($name)
            ->setStartDate($startDate)
            ->setEndDate($endDate)
        ;
    }

    /**
     * @param string $name
     * @return Event
     */
    public function defaultEvent(string $name): Event
    {
        $startDate = \DateTime::createFromFormat(DATE_ATOM, '1993-11-22T21:00:00+00:00');
        $endDate   = \DateTime::createFromFormat(DATE_ATOM, '1993-11-23T00:00:00+00:00');

        return $this->newEvent($name, $startDate, $endDate);
    }

}
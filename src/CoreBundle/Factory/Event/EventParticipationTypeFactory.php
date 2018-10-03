<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 17:33
 */

namespace CoreBundle\Factory\Event;


use CoreBundle\Entity\Event\EventParticipationType;


/**
 * @package CoreBundle\Factory\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationTypeFactory implements EventParticipationTypeFactoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function new(int $type): EventParticipationType
    {
        return (new EventParticipationType())
            ->setType($type)
        ;
    }

}

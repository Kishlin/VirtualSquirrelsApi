<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 15:00
 */

namespace CoreBundle\Manager;


use CoreBundle\Entity\EventParticipationType;

/**
 * @package CoreBundle\Manager
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
interface EventParticipationTypeManagerInterface
{

    /**
     * @param int $type
     * @return null|EventParticipationType
     */
    function getByType(int $type): ?EventParticipationType;

}
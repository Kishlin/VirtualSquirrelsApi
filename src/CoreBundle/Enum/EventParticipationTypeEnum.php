<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 28/09/2018
 * Time: 13:01
 */

namespace CoreBundle\Enum;


/**
 * @package CoreBundle\Enumerations
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
final class EventParticipationTypeEnum
{

    private function __construct() { }

    /** @var int */
    const TYPE_POSITIVE = 0;

    /** @var int */
    const TYPE_NEGATIVE = 1;

    /** @var int */
    const TYPE_UNSURE = 2;

    /** @var int */
    const TYPE_BACKUP = 3;


    /**
     * @return array
     */
    public static function getPossibleTypes(): array
    {
        return array(
            self::TYPE_POSITIVE,
            self::TYPE_NEGATIVE,
            self::TYPE_UNSURE,
            self::TYPE_BACKUP
        );
    }

}

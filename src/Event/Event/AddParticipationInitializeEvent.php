<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 17:53
 */

namespace App\Event\Event;


use App\Entity\Event\Event;
use App\Entity\User;

/**
 * @package App\Event\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AddParticipationInitializeEvent extends BaseUserEvent implements HasEventParticipationTypeInterface
{

    /** @var int */
    protected $type;

    /**
     * @param User  $user
     * @param Event $event
     * @param int   $type
     */
    public function __construct(User $user, Event $event, int $type)
    {
        parent::__construct($user, $event);

        $this->type  = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function getType(): int
    {
        return $this->type;
    }

}

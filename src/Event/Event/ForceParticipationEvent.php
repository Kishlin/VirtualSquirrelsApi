<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:40 AM
 */

namespace App\Event\Event;


use App\Entity\Event\Event;
use App\Entity\User;

/**
 * @package App\Event\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class ForceParticipationEvent extends BaseUserEvent
{

    /** @var User */
    protected $requestingUser;

    /**
     * @param User  $requestingUser
     * @param User  $user
     * @param Event $event
     */
    public function __construct(User $requestingUser, User $user, Event $event)
    {
        parent::__construct($user, $event);

        $this->requestingUser = $requestingUser;
    }


    /**
     * @return User
     */
    public function getRequestingUser(): User
    {
        return $this->requestingUser;
    }

}

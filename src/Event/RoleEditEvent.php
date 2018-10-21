<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 13:02
 */

namespace App\Event;


use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;

/**
 * @package App\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class RoleEditEvent extends Event
{

    /** @var null|Response */
    protected $response;

    /** @var User */
    protected $user;

    /** @var string */
    protected $role;

    /**
     * @param User   $user
     * @param string $role
     */
    public function __construct(User $user, string $role)
    {
        $this->user = $user;
        $this->role = $role;
    }


    /**
     * @param Response $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    /**
     * @return null|Response
     */
    public function getResponse(): ?Response
    {
        return $this->response;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

}

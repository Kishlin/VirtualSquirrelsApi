<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/23/2018
 * Time: 6:31 PM
 */

namespace CoreBundle\Listener;

use CoreBundle\CoreEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\EventListener\AuthenticationListener as BaseListener;
use FOS\UserBundle\Security\LoginManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class AuthenticationListener
 * @package   CoreBundle\Listener
 * @author    Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @copyright 2017 Pierre-Louis Legrand
 * @link      http://www.pierrelouislegrand.fr
 */
class AuthenticationListener extends BaseListener
{

    /**
     * {@inheritdoc}
     */
    public function __construct(LoginManagerInterface $loginManager, string $firewallName)
    {
        parent::__construct($loginManager, $firewallName);
    }

    public static function getSubscribedEvents()
    {
        return array(
            CoreEvents::API_LOGIN => 'authenticate'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(FilterUserResponseEvent $event, $eventName, EventDispatcherInterface $eventDispatcher)
    {
        parent::authenticate($event, $eventName, $eventDispatcher);
    }

}
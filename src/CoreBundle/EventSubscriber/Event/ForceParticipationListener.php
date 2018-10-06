<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:51 AM
 */

namespace CoreBundle\EventSubscriber\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Event\Event\HasUserAndEventInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use UserBundle\UserRoles;

/**
 * @package CoreBundle\EventSubscriber\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 */
class ForceParticipationListener implements EventSubscriberInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /**
     * ForceParticipationListener constructor.
     * @param LoggerInterface       $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(CoreEvents::EVENT_FORCE_PARTICIPATION => 'onForceParticipation');
    }

    /**
     * The user given in the event is the one requesting the forced participation, not the user targeted for the participation.
     * @param HasUserAndEventInterface $dispatcherEvent
     */
    public function onForceParticipation(HasUserAndEventInterface $dispatcherEvent)
    {
        $event = $dispatcherEvent->getEvent();
        $user  = $dispatcherEvent->getUser();

        $this->logger->debug('Removing event participation if exists.', array(
            'user'   => $user->getId(),
            'event'  => $event->getId(),
            'method' => 'removeExistingParticipation',
            'class'  => self::class
        ));

        if (!$user->hasRole(UserRoles::ROLE_OFFICER))
            throw new AccessDeniedException('You are not allowed to force participations for this event.');
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 10/6/2018
 * Time: 11:51 AM
 */

namespace App\EventSubscriber\Event;


use App\CoreEvents;
use App\Event\Event\ForceParticipationEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\UserRoles;

/**
 * @package App\App\EventSubscriber\Event
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
     * @param ForceParticipationEvent $dispatcherEvent
     */
    public function onForceParticipation(ForceParticipationEvent $dispatcherEvent)
    {
        // TODO Event creator should be able to force participations on his event, even without officer role.

        $requestingUser = $dispatcherEvent->getRequestingUser();
        if (!$requestingUser->hasRole(UserRoles::ROLE_OFFICER)) {
            $this->logger->debug('Requesting user does not have role.', array(
                'user'   => $requestingUser->getId(),
                'method' => 'onForceParticipation',
                'class'  => self::class
            ));

            throw new AccessDeniedException('You are not allowed to force participations for this event.');
        }

        $user  = $dispatcherEvent->getUser();
        if (!$user->hasRole(UserRoles::ROLE_TRIAL)) {
            $this->logger->debug('Trying to force participation on user which cannot take part in events..', array(
                'user'   => $requestingUser->getId(),
                'method' => 'onForceParticipation',
                'class'  => self::class
            ));

            throw new BadRequestHttpException('The user is not allowed to take part in event.');
        }
    }

}

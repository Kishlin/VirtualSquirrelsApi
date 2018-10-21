<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 3:15 PM
 */

namespace CoreBundle\EventSubscriber\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Event\Event\EntityEvent;
use CoreBundle\Exception\AccessDeniedException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use UserBundle\UserRoles;

/**
 * @package CoreBundle\EventSubscriber\Event
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
class EntityEventListener implements EventSubscriberInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            CoreEvents::EVENT_ENTITY_INITIALIZE => 'onAttemptingModification'
        );
    }

    /**
     * @param EntityEvent $dispatcherEvent
     */
    public function onAttemptingModification(EntityEvent $dispatcherEvent)
    {
        // TODO Event creator should be able to modify his event, even without officer role.

        $event          = $dispatcherEvent->getEvent();
        $requestingUser = $dispatcherEvent->getUser();

        if (!$requestingUser->hasRole(UserRoles::ROLE_OFFICER)) {
            $this->logger->debug('Requesting user does not have role or is not the creator.', array(
                'user' => $requestingUser->getId(),
                'method' => 'onAttemptingModification',
                'class' => self::class
            ));

            throw new AccessDeniedException('You are not allowed modify this event.');
        }

        $this->logger->info('User is authorized to further modify the event.', array(
            'user'   => $requestingUser->getId(),
            'event'  => $event->getId(),
            'method' => 'onAttemptingModification',
            'class'  => self::class
        ));
    }

}

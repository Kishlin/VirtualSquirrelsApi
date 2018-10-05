<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 15:51
 */

namespace CoreBundle\EventSubscriber\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Event\Event\HasEventParticipationTypeInterface;
use CoreBundle\Manager\Event\EventParticipationManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @package CoreBundle\EventSubscriber\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class NewEventParticipationListener implements EventSubscriberInterface
{

    /** @var EventParticipationManagerInterface */
    protected $manager;

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param EventParticipationManagerInterface $manager
     * @param LoggerInterface                    $logger
     */
    public function __construct(EventParticipationManagerInterface $manager, LoggerInterface $logger)
    {
        $this->manager = $manager;
        $this->logger  = $logger;
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(CoreEvents::EVENT_ADD_PARTICIPATION_INITIALIZE => array(
            array('removeExistingParticipation', 256)
        ));
    }

    /**
     * @param HasEventParticipationTypeInterface $dispatcherEvent
     */
    public function removeExistingParticipation(HasEventParticipationTypeInterface $dispatcherEvent)
    {
        $event = $dispatcherEvent->getEvent();
        $user  = $dispatcherEvent->getUser();

        $this->logger->debug('Removing event participation if exists.', array(
            'user'   => $user->getId(),
            'event'  => $event->getId(),
            'method' => 'removeExistingParticipation',
            'class'  => self::class
        ));

        $this->manager->removeIfExists($event, $user);
    }

}

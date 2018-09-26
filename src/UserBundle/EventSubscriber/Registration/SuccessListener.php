<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 12:23
 */

namespace UserBundle\EventSubscriber\Registration;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package UserBundle\EventSubscriber\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class SuccessListener implements EventSubscriberInterface
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
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FOSUserEvents::REGISTRATION_SUCCESS => 'onSuccess');
    }

    /**
     * @param FormEvent $event
     */
    public function onSuccess(FormEvent $event)
    {
        $this->logger->debug('Setting response now that user has registered.');

        $event->setResponse(new JsonResponse(array('message' => 'User was created and logged in.')));
    }

}

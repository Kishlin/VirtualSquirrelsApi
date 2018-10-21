<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 12:23
 */

namespace App\EventSubscriber\User\Registration;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package App\App\EventSubscriber\User\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class SuccessListener implements EventSubscriberInterface
{

    /** @var string */
    const SUCCESS_MESSAGE = 'User was created and logged in.';

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
    public static function getSubscribedEvents(): array
    {
        return array(FOSUserEvents::REGISTRATION_SUCCESS => 'onSuccess');
    }

    /**
     * @param FormEvent $event
     */
    public function onSuccess(FormEvent $event): void
    {
        $event->setResponse(new JsonResponse(array('message' => self::SUCCESS_MESSAGE)));
    }

}

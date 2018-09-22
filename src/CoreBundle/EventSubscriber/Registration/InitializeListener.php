<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 7:23 PM
 */

namespace CoreBundle\EventSubscriber\Registration;

use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class InitializeListener
 * @package   CoreBundle\EventSubscriber\Registration
 * @author    Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @copyright 2017 Pierre-Louis Legrand
 * @link      http://www.pierrelouislegrand.fr
 */
class InitializeListener implements EventSubscriberInterface
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
        return array(FOSUserEvents::REGISTRATION_INITIALIZE => 'onInitialize');
    }

    /**
     * @param GetResponseUserEvent $event
     */
    public function onInitialize(GetResponseUserEvent $event)
    {
        if ($event->getRequest()->request->has('fos_user_registration_form'))
            return;

        $this->logger->warning(
            'Throwing exception after receiving a blank request.',
            array('method' => 'onInitialize', 'class' => self::class)
        );

        throw new BadRequestHttpException('Missing fos_user_registration_form values.');
    }

}
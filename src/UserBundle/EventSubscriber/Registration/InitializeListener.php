<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 7:23 PM
 */

namespace UserBundle\EventSubscriber\Registration;


use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package UserBundle\EventSubscriber\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class InitializeListener implements EventSubscriberInterface
{

    /** @var string */
    const ERROR_MESSAGE = 'Some required parameters are missing in request.';

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
        $this->logger->info($event->getRequest()->request->has('fos_user_registration_form') ? 'true' : 'false');

        if ($event->getRequest()->request->has('fos_user_registration_form'))
            return;

        if (null !== ($form = $event->getRequest()->request->get('fos_user_registration_form')))
            return;

        $data = array(
            'message' => self::ERROR_MESSAGE,
            'requirements' => array(
                'fos_user_registration_form[email]',
                'fos_user_registration_form[username]',
                'fos_user_registration_form[plainPassword][first]',
                'fos_user_registration_form[plainPassword][second]'
            )
        );

        $event->setResponse(new JsonResponse($data, 400));
    }

}
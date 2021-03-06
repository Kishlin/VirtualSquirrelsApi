<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 10/10/2018
 * Time: 16:04
 */

namespace App\EventSubscriber\User;


use FOS\UserBundle\Event\GetResponseUserEvent;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use App\UserEvents;

/**
 * @package App\App\EventSubscriber
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class FinalizeListener implements EventSubscriberInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var SerializerInterface */
    protected $serializer;

    /**
     * @param LoggerInterface     $logger
     * @param SerializerInterface $serializer
     */
    public function __construct(LoggerInterface $logger, SerializerInterface $serializer)
    {
        $this->logger     = $logger;
        $this->serializer = $serializer;
    }


    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserEvents::USER_CHANGED_FINALIZE => 'setResponse'
        );
    }

    /**
     * @param GetResponseUserEvent $event
     */
    public function setResponse(GetResponseUserEvent $event)
    {
        $user = $event->getUser();

        $this->logger->info('Serializing user before setting event response.', array(
            'user'   => $user->getId(),
            'method' => 'setResponse',
            'class'  => self::class
        ));

        $response = new Response($this->serializer->serialize($user, 'json'), 200);

        $event->setResponse($response);
    }

}

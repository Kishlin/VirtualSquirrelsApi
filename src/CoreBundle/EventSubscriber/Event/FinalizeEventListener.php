<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 04/10/2018
 * Time: 16:07
 */

namespace CoreBundle\EventSubscriber\Event;


use CoreBundle\CoreEvents;
use CoreBundle\Entity\Event\EventParticipation;
use CoreBundle\Enum\EventParticipationTypeEnum;
use CoreBundle\Event\Event\HasResponseInterface;
use CoreBundle\View\Event\EventAnswerListView;
use CoreBundle\View\Event\EventAnswerView;
use CoreBundle\View\Event\EventView;
use JMS\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;

class FinalizeEventListener implements EventSubscriberInterface
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
        $this->logger = $logger;
        $this->serializer = $serializer;
    }


    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            CoreEvents::EVENT_FINALIZE_EVENT => 'setResponse'
        );
    }

    /**
     * @param HasResponseInterface $dispatcherEvent
     */
    public function setResponse(HasResponseInterface $dispatcherEvent)
    {
        $event = $dispatcherEvent->getEvent();

        $array = array();
        foreach (EventParticipationTypeEnum::getPossibleTypes() as $type) {
            $array[$type] = array();
        }

        $event->getEventParticipationList()->forAll(function(int $index, EventParticipation $eventParticipation) use(&$array) {
            $id = $eventParticipation->getParticipant()->getId();
            $array[$eventParticipation->getEventParticipationType()->getType()][$id] = new EventAnswerView($id);
        });

        $eventAnswerList = new EventAnswerListView(
            $array[EventParticipationTypeEnum::TYPE_POSITIVE],
            $array[EventParticipationTypeEnum::TYPE_NEGATIVE],
            $array[EventParticipationTypeEnum::TYPE_UNSURE],
            $array[EventParticipationTypeEnum::TYPE_BACKUP]
        );

        $eventView = new EventView($event->getId(), $event->getName(), $event->getStartDate(), $event->getEndDate(), $eventAnswerList);

        $dispatcherEvent->setResponse(new Response($this->serializer->serialize($eventView, 'json'), 200));
    }

}
<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 03/10/2018
 * Time: 18:11
 */

namespace App\EventSubscriber\Event;


use App\CoreEvents;
use App\Enum\EventParticipationTypeEnum;
use App\Event\Event\HasEventParticipationTypeInterface;
use App\Exception\BadRequestException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * @package App\App\EventSubscriber\Event
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class EventParticipationTypeListener implements EventSubscriberInterface
{

    /** @var string */
    const TYPE_ERROR_MESSAGE = 'The given type is not accepted.';

    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param LoggerInterface                    $logger
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
        return array(CoreEvents::EVENT_ADD_PARTICIPATION_INITIALIZE => array(
            array('checkTypeConsistency', 0)
        ));
    }

    /**
     * @param HasEventParticipationTypeInterface $dispatcherEvent
     * @throws BadRequestException
     */
    public function checkTypeConsistency(HasEventParticipationTypeInterface $dispatcherEvent)
    {
        $type = $dispatcherEvent->getType();

        if (in_array($type, EventParticipationTypeEnum::getPossibleTypes()))
            return;

        $this->logger->info('Type is not accepted.', array('type' => $type, 'method' => 'checkTypeConsistency', 'class' => self::class));

        throw new BadRequestException(self::TYPE_ERROR_MESSAGE);
    }

}

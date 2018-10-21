<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 08/10/2018
 * Time: 11:35
 */

namespace UserBundle\EventSubscriber;


use FOS\UserBundle\Event\GetResponseUserEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package UserBundle\EventSubscriber
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
abstract class FormPostInitializeListener implements EventSubscriberInterface
{

    /** @var string */
    const ERROR_MESSAGE = 'Form is missing in request.';

    /** @var LoggerInterface */
    protected $logger;


    /**
     * @param GetResponseUserEvent $event
     */
    public function onInitialize(GetResponseUserEvent $event)
    {
        $formName = $this->getFormName();

        if ($event->getRequest()->request->has($formName))
            return;

        if (null !== ($form = $event->getRequest()->request->get($formName)))
            return;

        $requirements = $this->getRequirements();
        $data = array('message' => self::ERROR_MESSAGE, 'requirements' => $requirements);

        $event->setResponse(new JsonResponse($data, 400));
    }

    /**
     * @return string
     */
    abstract protected function getFormName(): string;

    /**
     * @return array
     */
    abstract protected function getRequirements(): array;

}

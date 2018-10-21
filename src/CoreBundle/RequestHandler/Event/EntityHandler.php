<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 2:55 PM
 */

namespace CoreBundle\RequestHandler\Event;

use CoreBundle\CoreEvents;
use CoreBundle\CoreForms;
use CoreBundle\Entity\Event\Event;
use CoreBundle\Event\Event\EventFinalizeEvent;
use CoreBundle\Event\FormFailureEvent;
use CoreBundle\Exception\BadRequestException;
use CoreBundle\Form\Type\Event\EventType;
use CoreBundle\Manager\Event\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Entity\User;

/**
 * @package CoreBundle\RequestHandler\Event
 * @author Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link https://pierrelouislegrand.fr
 */
class EntityHandler implements EntityHandlerInterface
{

    /** @var LoggerInterface */
    protected $logger;

    /** @var FormFactoryInterface */
    protected $formFactory;

    /** @var EntityManagerInterface */
    protected $eventManager;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /**
     * @param LoggerInterface          $logger
     * @param FormFactoryInterface     $formFactory
     * @param EntityManagerInterface   $eventManager
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(LoggerInterface $logger,
                                FormFactoryInterface $formFactory,
                                EntityManagerInterface $eventManager,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->logger          = $logger;
        $this->formFactory     = $formFactory;
        $this->eventManager    = $eventManager;
        $this->eventDispatcher = $eventDispatcher;
    }


    /**
     * {@inheritdoc}
     */
    public function handleEventForm(Request $request, User $requestingUser, ?Event $event): Response
    {
        $logContext = array(
            'event'  => $event === null ? 'null' : $event->getId(),
            'user'   => $requestingUser->getId(),
            'method' => 'handleEventForm',
            'class'  => self::class
        );

        $this->logger->debug('Handling form request.', $logContext);

        $event === null && $event = new Event();

        $form = $this->formFactory->createNamed(CoreForms::FORM_EVENT, EventType::class, $event);

        $form->handleRequest($request);

        !$form->isSubmitted() && $this->handleUnsubmittedForm($logContext);

        return $form->isValid() ?
            $this->handleValidForm($requestingUser, $event, $logContext) :
            $this->handleInvalidForm($logContext, $form)
        ;
    }

    /**
     * @param array $logContext
     * @throws BadRequestException
     */
    protected function handleUnsubmittedForm(array $logContext): void
    {
        $this->logger->info('Form is not submitted.', $logContext);

        throw new BadRequestException('Form is not submitted.');
    }

    /**
     * @param User       $requestingUser
     * @param Event|null $event
     * @param array      $logContext
     * @return Response
     */
    protected function handleValidForm(User $requestingUser, ?Event $event, array $logContext): Response
    {
        $this->logger->debug('Form is valid.', $logContext);

        $event = $this->eventManager->saveEvent($event);

        $finalizeEvent = new EventFinalizeEvent($requestingUser, $event);
        $this->eventDispatcher->dispatch(CoreEvents::EVENT_FINALIZE_EVENT, $finalizeEvent);

        return $finalizeEvent->getResponse() ?? new Response();
    }

    /**
     * @param array         $logContext
     * @param FormInterface $form
     * @return Response
     */
    protected function handleInvalidForm(array $logContext, FormInterface $form): Response
    {
        $this->logger->debug('Form is invalid.', $logContext);

        $failureEvent = new FormFailureEvent($form);
        $this->eventDispatcher->dispatch(CoreEvents::EVENT_FORM_FAILURE, $failureEvent);

        return $failureEvent->getResponse() ?? new Response('', 400);
    }

}
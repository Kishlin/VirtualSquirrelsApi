<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 08/10/2018
 * Time: 11:51
 */

namespace App\Controller\User;


use App\Exception\BadRequestException;
use App\Exception\LogicException;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FormFactory;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use App\UserEvents;

/**
 * @package App\Controller
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class ChangePasswordController extends Controller
{

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var FormFactory */
    protected $formFactory;

    /** @var UserManagerInterface */
    protected $userManager;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param FormFactory              $formFactory
     * @param UserManagerInterface     $userManager
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, FormFactory $formFactory, UserManagerInterface $userManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->formFactory     = $formFactory;
        $this->userManager     = $userManager;
    }


    /**
     * @param Request $request
     * @return Response
     * @throws BadRequestException
     */
    public function changePasswordAction(Request $request): Response
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $initializeEvent = new GetResponseUserEvent($user, $request);
        $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_INITIALIZE, $initializeEvent);

        if (null !== $initializeEvent->getResponse()) {
            return $initializeEvent->getResponse();
        }

        $form = $this->formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            throw new BadRequestException('Form is not submitted.');
        }

        if ($form->isValid()) {
            $successEvent = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_SUCCESS, $successEvent);

            $this->userManager->updateUser($user);

            if (null === $response = $successEvent->getResponse()) {
                $response = new Response();
            }

            $completedEvent = new FilterUserResponseEvent($user, $request, $response);
            $this->eventDispatcher->dispatch(FOSUserEvents::CHANGE_PASSWORD_COMPLETED, $completedEvent);


            $finalizeEvent = new GetResponseUserEvent($user, $request);
            $this->eventDispatcher->dispatch(UserEvents::USER_CHANGED_FINALIZE, $finalizeEvent);

            if (null === $response = $finalizeEvent->getResponse()) {
                throw new LogicException('Finalize event should have a response.');
            }

            return $response;
        } else {
            $failureEvent = new FormEvent($form, $request);
            $this->eventDispatcher->dispatch(UserEvents::PROFILE_FORM_FAILURE_EVENT, $failureEvent);

            if (null === $response = $failureEvent->getResponse()) {
                throw new LogicException('Failure event should have a response.');
            }

            return $response;
        }
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 5:18 PM
 */

namespace UserBundle\EventSubscriber\Registration;


use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @package UserBundle\EventSubscriber\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class FailureListener implements EventSubscriberInterface
{

    /** @var string */
    const ERROR_MESSAGE = 'Form failure.';

    /** @var array */
    const FIELDS = array(
        'data.username'           => 'username',
        'data.email'              => 'email',
        'data.plainPassword'      => 'password',
        'children[plainPassword]' => 'password'
    );

    /** @var array */
    const ERRORS = array(
        UniqueEntity::class => 'taken',
        NotBlank::class     => 'blank',
        Form::class         => 'unequal',
        Email::class        => 'format'
    );


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
        return array(FOSUserEvents::REGISTRATION_FAILURE => 'onFailure');
    }

    /**
     * @param FormEvent $event
     */
    public function onFailure(FormEvent $event): void
    {
        $data = array('message' => self::ERROR_MESSAGE);
        $errors = $event->getForm()->getErrors(true);

        foreach ($errors as $key => $formError) { /** @var FormError $formError */

            $cause = $formError->getCause(); /** @var ConstraintViolation $cause */
            $key   = self::FIELDS[$cause->getPropertyPath()];
            $type = self::ERRORS[get_class($cause->getConstraint())];

            $this->logger->debug(
                self::ERROR_MESSAGE,
                array('errorKey' => $key, 'errorType' => $type, 'method' => 'onFailure', 'class' => self::class)
            );

            $data['errors'][$key] = $type;
        }

        $event->setResponse(new JsonResponse($data, 400));
    }

}
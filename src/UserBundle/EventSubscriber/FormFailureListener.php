<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 08/10/2018
 * Time: 11:44
 */

namespace UserBundle\EventSubscriber;


use FOS\UserBundle\Event\FormEvent;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Validator\Constraints\Form;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @package UserBundle\EventSubscriber
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
abstract class FormFailureListener implements EventSubscriberInterface
{

    /** @var string */
    const ERROR_MESSAGE = 'Form failure.';

    /** @var array */
    const ERRORS = array(
        UserPassword::class => 'invalid',
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
     * @param FormEvent $event
     */
    public function onFailure(FormEvent $event): void
    {
        $fields = $this->getPropertyKeyArray();

        $data = array('message' => self::ERROR_MESSAGE);
        $errors = $event->getForm()->getErrors(true);

        foreach ($errors as $key => $formError) { /** @var FormError $formError */

            $cause = $formError->getCause(); /** @var ConstraintViolation $cause */
            $key   = $fields[$cause->getPropertyPath()];
            $type = self::ERRORS[get_class($cause->getConstraint())];

            $this->logger->debug(
                self::ERROR_MESSAGE,
                array('errorKey' => $key, 'errorType' => $type, 'method' => 'onFailure', 'class' => self::class)
            );

            $data['errors'][$key] = $type;
        }

        $event->setResponse(new JsonResponse($data, 400));
    }

    /**
     * @return array
     */
    abstract protected function getPropertyKeyArray(): array;

}

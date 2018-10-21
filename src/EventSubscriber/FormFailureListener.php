<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Link: https://pierrelouislegrand.fr
 * Date: 10/20/18
 * Time: 11:07 PM
 */

namespace App\EventSubscriber;


use App\CoreEvents;
use App\Event\FormFailureEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\ConstraintViolation;

/**
 * @package App\App\EventSubscriber
 * @author  Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * @link    https://pierrelouislegrand.fr
 */
class FormFailureListener implements EventSubscriberInterface
{

    /** @var string */
    const MESSAGE = 'Form is invalid.';


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
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            CoreEvents::EVENT_FORM_FAILURE => 'onFormFailure'
        );
    }

    /**
     * @param FormFailureEvent $event
     */
    public function onFormFailure(FormFailureEvent $event)
    {
        $form = $event->getForm();

        $errors = array();
        foreach ($form->getErrors(true, true) as $formError) {
            /** @var ConstraintViolation $cause */
            $cause = $formError->getCause();

            $propertyPath = $cause->getPropertyPath();
            $message      = $formError->getMessage();
            $errors[$propertyPath] = $message;

            $value = $cause->getInvalidValue();

            $this->logger->info('Invalid form value', array(
                'message'   => $message,
                'property' => $propertyPath,
                'value'    => $value,
                'method'   => 'onFormFailure',
                'class'    => self::class
            ));
        }

        $array = array('message' => self::MESSAGE, 'errors' => $errors);
        $response = new JsonResponse($array, 400);

        $event->setResponse($response);
    }

}

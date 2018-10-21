<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 5:18 PM
 */

namespace App\EventSubscriber\User\Registration;


use FOS\UserBundle\FOSUserEvents;
use App\EventSubscriber\FormFailureListener;

/**
 * @package App\App\EventSubscriber\User\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class FailureListener extends FormFailureListener
{

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents(): array
    {
        return array(FOSUserEvents::REGISTRATION_FAILURE => 'onFailure');
    }

    /**
     * {@inheritDoc}
     */
    protected function getPropertyKeyArray(): array
    {
        return array(
            'data.username'           => 'username',
            'data.email'              => 'email',
            'data.plainPassword'      => 'password',
            'children[plainPassword]' => 'password'
        );
    }

}

<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 5:18 PM
 */

namespace App\EventSubscriber\User\Profile\ChangePassword;


use App\EventSubscriber\FormFailureListener;
use App\UserEvents;

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
        return array(UserEvents::PROFILE_FORM_FAILURE_EVENT => 'onFailure');
    }

    /**
     * {@inheritDoc}
     */
    protected function getPropertyKeyArray(): array
    {
        return array(
            'children[current_password].data' => 'password',
            'data.current_password'   => 'password',
            'data.plainPassword'      => 'newPassword',
            'children[plainPassword]' => 'newPassword'
        );
    }

}

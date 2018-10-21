<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/22/2018
 * Time: 7:23 PM
 */

namespace App\EventSubscriber\User\Registration;


use FOS\UserBundle\FOSUserEvents;
use App\EventSubscriber\FormPostInitializeListener;

/**
 * @package App\App\EventSubscriber\User\Registration
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class InitializeListener extends FormPostInitializeListener
{

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_INITIALIZE => 'onInitialize'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequirements(): array
    {
        return array(
            'fos_user_registration_form[email]',
            'fos_user_registration_form[username]',
            'fos_user_registration_form[plainPassword][first]',
            'fos_user_registration_form[plainPassword][second]'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormName(): string
    {
        return 'fos_user_registration_form';
    }

}
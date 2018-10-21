<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 08/10/2018
 * Time: 11:31
 */

namespace App\EventSubscriber\User\Profile\ChangePassword;


use FOS\UserBundle\FOSUserEvents;
use App\EventSubscriber\FormPostInitializeListener;

/**
 * @package App\App\EventSubscriber\User\Profile\ChangePassword
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
            FOSUserEvents::CHANGE_PASSWORD_INITIALIZE => 'onInitialize'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequirements(): array
    {
        return array(
            'fos_user_change_password_form[current_password]',
            'fos_user_change_password_form[plainPassword][first]',
            'fos_user_change_password_form[plainPassword][second]'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormName(): string
    {
        return 'fos_user_change_password_form';
    }

}

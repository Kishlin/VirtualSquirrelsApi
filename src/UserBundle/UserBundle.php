<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/26/2018
 * Time: 9:18 AM
 */

namespace UserBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @package UserBundle
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class UserBundle extends Bundle
{

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}

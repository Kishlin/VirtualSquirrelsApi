<?php
/**
 * User: Pierre-Louis Legrand <hello@pierrelouislegrand.fr>
 * Date: 9/23/2018
 * Time: 6:03 PM
 */

namespace CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @package CoreBundle\Controller
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class AuthController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function whoAmIAction(): JsonResponse
    {
        return new JsonResponse(
            (null === ($user = $this->getUser())) ? array('message' => 'User is not logged in.') : array('user' => $user->getEmail())
        );
    }

}
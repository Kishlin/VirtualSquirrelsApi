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
 * Class CoreController
 */
class CoreController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function whoAmIAction(): JsonResponse
    {
        if (null === ($user = $this->getUser())) throw new \RuntimeException('User is not authenticated.');

        return new JsonResponse(array('user' => $user->getEmail()));
    }


}
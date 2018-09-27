<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 11:41
 */

namespace UserBundle\Handler\Security;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

/**
 * @package UserBundle\Handler\Security
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class LogoutSuccess implements LogoutSuccessHandlerInterface
{

    /**
     * {@inheritdoc}
     */
    public function onLogoutSuccess(Request $request): JsonResponse
    {
        return new JsonResponse(array('message' => 'User has logged out.'));
    }

}
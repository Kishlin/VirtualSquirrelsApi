<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 15:23
 */

namespace CoreBundle\Controller;


use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;

/**
 * @package CoreBundle\Controller
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class LoadingController extends FOSRestController
{

    /**
     * @Get("/loading")
     * @View()
     *
     * @return Response
     */
    public function loadingAction(): Response
    {
        $data = array('user' => $this->getUser() ?? array());

        $data['userList'] = $this->getDoctrine()->getRepository('UserBundle:User')->findBy(array(), array('id' => 'asc'));

        $view = $this->view($data, 200);

        return $this->handleView($view);

    }

}
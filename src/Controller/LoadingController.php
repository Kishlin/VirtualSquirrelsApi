<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 15:23
 */

namespace App\Controller;


use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializerInterface;

/**
 * @package App\Controller
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class LoadingController extends FOSRestController
{

    /** @var SerializerInterface */
    protected $serializer;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * @Get("/loading", name="core_loading", options={ "method_prefix" = false })
     * @View()
     */
    public function loadingAction()
    {
        $data['user'] = $this->getUser() ?? array();
        $data['userList'] =  $this->getDoctrine()->getRepository('App:User')->findBy(array(), array('id' => 'asc'));

        $view = $this->view($data, 200);

        return $view;
    }

}
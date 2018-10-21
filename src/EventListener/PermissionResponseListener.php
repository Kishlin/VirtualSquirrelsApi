<?php
/**
 * User: Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 * Date: 26/09/2018
 * Time: 16:40
 */

namespace App\EventListener;


use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use FOS\RestBundle\Controller\Annotations\View as ViewAnnotation;
use App\Entity\User;

/**
 * @package App\EventListener
 * @author  Pierre-Louis Legrand <pierrelouis.legrand@playrion.com>
 */
class PermissionResponseListener
{

    /** @var AuthorizationCheckerInterface */
    private $authorizationChecker;

    /**
     * @param AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }


    /**
     * @param GetResponseForControllerResultEvent $event
     */
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $attr = $event->getRequest()->attributes;
        if (null === $viewAttribute = $attr->get('_template')) {
            $viewAttribute = new ViewAnnotation(array());
            $viewAttribute->setPopulateDefaultVars(false);
            $attr->set('_template', $viewAttribute);
        }

        $groups = $viewAttribute->getSerializerGroups();
        $groups[] = 'default';

        foreach (User::getPossibleRoles() as $role) {
            if ($this->authorizationChecker->isGranted($role)) {
                $groups[] = 'has_' . strtolower($role);
            }
        }

        $viewAttribute->setSerializerGroups($groups);
    }

}
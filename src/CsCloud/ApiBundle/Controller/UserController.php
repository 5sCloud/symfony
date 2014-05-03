<?php


namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use CsCloud\ApiBundle\View\View;

class UserController extends BaseRestController
{
    /**
     * @REST\Get("/user/info")
     * @REST\View()
     */
    public function userInformationAction()
    {
        $security_context = $this->get('security.context');
        $currentUser = $security_context->getToken()->getUser();

        $view = View::create($currentUser, 200, array());
        $view->setSerializationContext($this->getSerializationContext());
        return $view;
    }
}

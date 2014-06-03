<?php


namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use CsCloud\CoreBundle\Entity\User;
use CsCloud\ApiBundle\View\View;

/**
 * Controller for User entity
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class UserController extends BaseRestController
{
    /**
     * @REST\Get("/user/info")
     * @REST\View()
     *
     * This action is needed by the OAuth login process
     */
    public function userInformationAction()
    {
        // Get current user
        $security_context = $this->get('security.context');
        $currentUser = $security_context->getToken()->getUser();

        // Not a user
        if (!$currentUser instanceof User) {
            throw $this->createNotFoundException();
        }

        // Do NOT call $this->view!
        $view = View::create($currentUser, 200, array());
        $view->setSerializationContext($this->getSerializationContext());
        return $view;
    }
}

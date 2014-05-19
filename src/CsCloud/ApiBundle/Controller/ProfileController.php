<?php

namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpFoundation\Request;

use CsCloud\CoreBundle\Entity\User;

/**
 * CRUD controller for UserProfile entity
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 * @author Edoardo Rossi <edo@ravers.it>
 */
class ProfileController extends BaseRestController
{
    /**
     * @REST\Post("/profile")
     * @REST\View()
     *
     * @ApiDoc({
     *      "description" = "Save user profile information"
     * })
     */
    public function saveAction(Request $request)
    {
        // Get current user
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        // User is not an entity (probably the user is not logged in)
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $profile = $user->getProfile();
        $form = $this->get('form.factory')->createNamed(null, 'cscloud_userprofile', $profile, array('csrf_protection' => false));

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->persist($profile);
            $em->flush();
        } else {
            return $this->view($this->getAllErrors($form), 400);
        }

        return $this->view($profile);
    }
}

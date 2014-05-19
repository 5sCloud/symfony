<?php

namespace CsCloud\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use CsCloud\CoreBundle\Form\Type\UserProfileType;
use CsCloud\CoreBundle\Controller\ApiTrait;
use CsCloud\CoreBundle\Entity\User;

/**
 * CRUD controller for UserProfile entity on frontend
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 * @author Edoardo Rossi <edo@ravers.it>
 */
class ProfileController extends Controller
{
    use ApiTrait;

    public function editAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        // User is not an entity (probably the user is not logged in)
        if (!$user instanceof User) {
            throw new AccessDeniedHttpException;
        }

        $profile = $user->getProfile();
        $form = $this->get('form.factory')->createNamed('profile', new UserProfileType(), $profile);

        if ($request->getMethod() === 'POST') {
            return $this->handleSave($request);
        }

        return $this->render('CsCloudFrontendBundle:Profile:profile.html.twig', array('form' => $form->createView()));
    }

    public function handleSave(Request $request)
    {
        $ar = $this->createApiRequestFromRequest($request, '/profile', array(), array('param_name' => 'profile'));
        $ar->setSafeCodes(array(400));
        $response = $this->getApiManager()->performRequest($ar);

        if ($response->isSuccessful()) {
            return $this->redirect($this->generateUrl('cs_cloud_frontend_profile_edit'), 303);
        } else {
            // TODO: handle this case
            die('INVALID FORM');
        }
    }
}

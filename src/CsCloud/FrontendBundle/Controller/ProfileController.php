<?php

namespace CsCloud\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CsCloud\CoreBundle\Form\Type\UserProfileType;
use CsCloud\CoreBundle\Controller\ApiTrait;
use Symfony\Component\Validator\Constraints\Null;

class ProfileController extends Controller
{
    use ApiTrait;

    public function EditAction() {

        $user = $this->container->get('security.context')->getToken()->getUser();
        $profileData = $user->getProfile();

        $form = $this->createForm(new UserProfileType(), $profileData , array('action' => $this->get('router')->generate('cs_cloud_frontend_profilo_save')));

        return $this->render('CsCloudFrontendBundle:Profile:Profile.html.twig',array('form' => $form->createView()));
    }

    public function SaveAction(Request $request) {
        $user = $this->container->get('security.context')->getToken()->getUser();

        $form = $this->createForm(new UserProfileType());

        $form->handleRequest($request);

        if ($form->isValid()) {

            $registration = $form->getData();

            $url = '/Profile';
            $query = Array ();
            $query["Name"] = $registration->getName();
            $query["Surname"] = $registration->getSurname();
            $query["Work"] = $registration->getWork();
            $query["Hobby"] = $registration->getHobby();
            $query["HousePhone"] = $registration->getHousePhone();
            $query["CellPhone"] = $registration->getCellPhone();

            $return = $this->createApiRequest($url, $query);

        }
        return $this->redirect($this->generateUrl('cs_cloud_frontend_profilo'));

    }
}

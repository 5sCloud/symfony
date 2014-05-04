<?php

namespace CsCloud\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CsCloud\CoreBundle\Form\Type\ProfileType;
use CsCloud\CoreBundle\Form\Model\Profile;
use Symfony\Component\Validator\Constraints\Null;

class ProfileController extends Controller
{
    /**
     * @Route("/Profilo")
     * @Template()
     */

    public function EditAction(Request $request ,$Action) {

        $user = $this->container->get('security.context')->getToken()->getUser();

        if ($Action == 'Save') {

            $em = $this->getDoctrine()->getManager();
            $form = $this->createForm(new ProfileType(), new Profile());

            $form->handleRequest($request);

            if ($form->isValid()) {

                $registration = $form->getData();

                $userpro = $registration->getUserProfile();

                $exist = $this->getDoctrine()->getRepository('CsCloudCoreBundle:UserProfile')->find($user->getId());

                if (!$exist) {
                    $userpro->setUser($this->getDoctrine()->getRepository('CsCloudCoreBundle:User')->find($user->getId()));
                    $em->persist($userpro);

                } else {
                    $exist->setName($userpro->getName());
                    $exist->setSurname($userpro->getSurname());
                    $exist->setWork($userpro->getWork());
                    $exist->setHobby($userpro->getHobby());
                    $exist->setHousePhone($userpro->getHousePhone());
                    $exist->setCellPhone($userpro->getCellPhone());

                }
                $em->flush();

            }
            return $this->redirect($this->generateUrl('cs_cloud_frontend_profilo'));
        }

        $user = $this->container->get('security.context')->getToken()->getUser()->getId();
        $profileData = $this->getDoctrine()->getRepository('CsCloudCoreBundle:UserProfile')->find($user);

        $profile = new Profile();
        if ($profileData)
            $profile->setUserProfile($profileData);

        $form = $this->createForm(new ProfileType(), $profile , array('action' => $this->get('router')->generate('cs_cloud_frontend_profilo' , array('Action' => 'Save'))));

        return $this->render('CsCloudFrontendBundle:Profile:Profile.html.twig',array('form' => $form->createView()));
    }

}

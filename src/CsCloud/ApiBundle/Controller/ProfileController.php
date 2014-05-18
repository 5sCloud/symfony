<?php

namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends BaseRestController
{
    /**
     * @REST\Post("/Profile")
     * @REST\View()
     *
     * @ApiDoc({
     *      "description"="save user profile informartion"
     * })
     */
    public function postSaveAction(Request $request)
    {
        try{
            $user = $this->container->get('security.context')->getToken()->getUser();
            $em = $this->getDoctrine()->getManager();
            $userprofile = $user->getProfile();

            $userprofile->setName($request->get('Name'));
            $userprofile->setSurname($request->get('Surname'));
            $userprofile->setWork($request->get('Work'));
            $userprofile->setHobby($request->get('Hobby'));
            $userprofile->setHousePhone($request->get('HousePhone'));
            $userprofile->setCellPhone($request->get('CellPhone'));
            $userprofile->setAvatar($request->get('Avatar'));
            $userprofile->preUpload();
            $userprofile->upload();

            $em->persist($userprofile);
            $em->flush();

            return $this->view(array(
                'return-code' => 'OK',
                'message' => ''
            ));
        } catch(\Doctrine\ORM\ORMException $e) {
            return $this->view(array(
                'return-code' => 'ER',
                'message' => ''
            ));
        }
    }
}

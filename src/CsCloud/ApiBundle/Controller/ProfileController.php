<?php

namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends BaseRestController
{
    /**
     * @REST\Get("/Profile")
     * @REST\View()
     *
     * @ApiDoc({
     *      "description"="save user profile informartion"
     * })
     */
    public function SaveAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $userprofile = $user->getProfile();

        var_dump($request->query->get('Name'));
        $userprofile->setName($request->query->get('Name'));
        $userprofile->setSurname($request->query->get('Surname'));
        $userprofile->setWork($request->query->get('Work'));
        $userprofile->setHobby($request->query->get('Hobby'));
        $userprofile->setHousePhone($request->query->get('HousePhone'));
        $userprofile->setCellPhone($request->query->get('CellPhone'));

        $em->persist($userprofile);
        $em->flush();

        return $this->view(array(
            'return-code' => 'OK',
            'message' => ''
        ));
    }
}

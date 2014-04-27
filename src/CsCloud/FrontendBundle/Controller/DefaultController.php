<?php

namespace CsCloud\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function homepageAction()
    {
        return $this->render('CsCloudFrontendBundle:Default:homepage.html.twig');
    }

    public function indexAction($name)
    {
        return $this->render('CsCloudFrontendBundle:Default:index.html.twig', array('name' => $name));
    }
}

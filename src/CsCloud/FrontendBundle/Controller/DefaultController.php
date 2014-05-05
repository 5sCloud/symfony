<?php

namespace CsCloud\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    use \CsCloud\CoreBundle\Controller\ApiTrait;
    public function homepageAction()
    {
        return $this->render('CsCloudFrontendBundle:Default:homepage.html.twig');
    }

    public function indexAction($name)
    {
        return $this->render('CsCloudFrontendBundle:Default:index.html.twig', array('name' => $name));
    }

    public function odfAction($filename)
    {
        return $this->render('CsCloudFrontendBundle:Default:odf.html.twig', array('filename' => $filename));
    }
}

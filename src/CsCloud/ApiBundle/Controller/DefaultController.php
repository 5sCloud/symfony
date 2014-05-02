<?php

namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends BaseRestController
{
    /**
     * @REST\Route("/")
     * @REST\View()
     *
     * @ApiDoc({
     *      "description"="Returns the project name and current API version"
     * })
     */
    public function indexAction()
    {
        return $this->view(array(
            'name' => 'cs-cloud',
            'version' => 'dev-experimental'
        ));
    }
}
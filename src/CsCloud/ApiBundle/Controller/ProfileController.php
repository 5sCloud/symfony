<?php

namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends BaseRestController
{
    /**
     * @REST\Get("/")
     * @REST\View()
     *
     * @ApiDoc({
     *      "description"="Returns the project name and current API version"
     * })
     */
    public function SaveAction()
    {
        return $this->view(array(
            'name' => 'cscloud',
            'version' => 'dev-experimental'
        ));
    }
}

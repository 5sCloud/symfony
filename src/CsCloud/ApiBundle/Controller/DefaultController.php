<?php

namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

/**
 * Default index controller
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
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
    public function indexAction()
    {
        return $this->view(array(
            'name' => 'cscloud',
            'version' => 'dev-experimental'
        ));
    }
}

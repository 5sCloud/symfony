<?php


namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\Annotations as REST;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use CsCloud\ApiBundle\View\View;

class UserController extends BaseRestController
{
    /**
     * @REST\Get("/gruppo/{id}/info")
     * @REST\View()
     */
    public function gruppoInformationAction($id)
    {

        $gruppo = array();
        $view = View::create($gruppo, 200, array());
        $view->setSerializationContext($this->getSerializationContext());
        return $view;
    }
    /**
     * @REST\Get("/gruppo/{id}/edit")
     * @REST\View()
     */
    public function gruppoEditAction($id)
    {

        $gruppo = array();
        $view = View::create($gruppo, 200, array());
        $view->setSerializationContext($this->getSerializationContext());
        return $view;
    }
    /**
     * @REST\Get("/gruppo/{id}/delete")
     * @REST\View()
     */
    public function gruppoDeleteAction($id)
    {

        $data = array('success'=>true);
        $view = View::create($data, 200, array());
        $view->setSerializationContext($this->getSerializationContext());
        return $view;
    }
    /**
     * @REST\Get("/gruppi/create")
     * @REST\View()
     */
    public function gruppCreateAction()
    {

        $gruppo = array();
        $view = View::create($gruppo, 200, array());
        $view->setSerializationContext($this->getSerializationContext());
        return $view;
    }
    /**
     * @REST\Get("/gruppi/{father}/create")
     * @REST\View()
     */
    public function gruppCreateChildAction($father)
    {

        $gruppo = array();
        $view = View::create($gruppo, 200, array());
        $view->setSerializationContext($this->getSerializationContext());
        return $view;
    }
}

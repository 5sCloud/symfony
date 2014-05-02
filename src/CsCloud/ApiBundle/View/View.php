<?php

namespace CsCloud\ApiBundle\View;

use FOS\RestBundle\View\View as BaseView;

class View extends BaseView
{
    private $response = null;

    /**
     * Get the response
     *
     * @return Response response
     */
    public function getResponse()
    {
        if (null === $this->response) {
            $this->response = new Response();
        }

        return $this->response;
    }
}

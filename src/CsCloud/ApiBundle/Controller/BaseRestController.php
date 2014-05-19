<?php

namespace CsCloud\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use CsCloud\ApiBundle\View\View;
use CsCloud\ApiBundle\Util\ResponseWrapper;

use JMS\Serializer\SerializationContext;

/**
 * Base controller for rest requests.
 * The {@link view()} method has been overridden in order to return HTTP code and status
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
abstract class BaseRestController extends FOSRestController
{
    use \CsCloud\CoreBundle\Controller\RequestTrait;
    use \CsCloud\CoreBundle\Controller\FormErrorsTrait;

    protected $serializationGroups = array();
    protected $serializationContext = null;

    /**
     * Overridden FOSRestController::view method that return a coherent response
     *
     * @see FOSRestController::view
     *
     * @param mixed $data
     * @param integer $statusCode
     * @param array $headers
     * @return View
     */
    protected function view($data = null, $statusCode = 200, array $headers = array())
    {
        $view = View::create(new ResponseWrapper($statusCode, $data), $statusCode, $headers);
        $view->setSerializationContext($this->getSerializationContext());

        return $view;
    }

    /**
     * Set serialization groups for current request
     *
     * @param array $groups
     */
    protected function setSerializationGroups(array $groups)
    {
        $this->serializationGroups = $groups;
    }

    /**
     * Returns the serialization context used in {@link view} method
     *
     * @return SerializationContext
     */
    protected function getSerializationContext()
    {
        if ($this->serializationContext === null) {
            $this->initSerializationContext();
        }

        return $this->serializationContext;
    }

    /**
     * Creates a new serialization context
     */
    protected function initSerializationContext()
    {
        $this->serializationContext = new SerializationContext();

        $this->serializationContext->setSerializeNull(true);
        if ($this->serializationGroups) {
            $this->serializationContext->setGroups($this->serializationGroups);
        }
    }

    protected function createAccessDeniedException($message = null)
    {
        if (null === $message) {
            $message = ResponseWrapper::getStatusMessage(403);
        }

        return new AccessDeniedHttpException($message);
    }
}

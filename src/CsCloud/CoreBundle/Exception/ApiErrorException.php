<?php

namespace CsCloud\CoreBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * This exception is thrown when the request to the API did not return
 * a valid response code (200)
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class ApiErrorException extends \Exception
{
    /**
     * The response object
     * @var Response
     */
    protected $response;

    public function __construct($message, Response $response)
    {
        parent::__construct($message);
        $this->response = $response;
    }

    /**
     * Get the failing response
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }
}

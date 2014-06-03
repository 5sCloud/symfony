<?php

namespace CsCloud\CoreBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

use CsCloud\CoreBundle\Services\Util\ApiManager;
use CsCloud\CoreBundle\Services\Util\ApiRequest;

use CsCloud\CoreBundle\Exception\InvalidApiResponseException;
use CsCloud\CoreBundle\Exception\ApiErrorException;

use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;

use Symfony\Component\HttpFoundation\Request;
/**
 * ApiTrait contains useful methods to instantiate and perform
 * an api request and handle the response
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
trait ApiTrait
{
    /**
     * Response here MUST be valid
     */
    protected function getData(Response $response)
    {
        $content_type = $response->headers->get('Content-Type');
        switch($content_type)
        {
            case 'application/json':
                return $this->getDataFromJson($response);
            default:
                throw new InvalidApiResponseException(
                        'Unrecognizable Content-Type of API response'
                        . ' (' . $content_type . ')');
        }
    }

    protected function getDataFromJson(Response $response)
    {
        $body = json_decode($response->getContent());
        return $body->data;
    }

    /**
     * @return ApiManager
     */
    protected function getApiManager()
    {
        return $this->get('cs_cloud_core.api_request_manager');
    }

    /**
     * Create a new ApiRequest object
     * @param string $uri
     * @param array $query
     * @return ApiRequest
     */
    protected function createApiRequest($uri, $query = array())
    {
        $request = new ApiRequest($uri, $query);

        $rs = $this->get('request_stack');
        $current_request = $rs->getCurrentRequest();
        if (null !== $current_request) {
            $request->setLocale($current_request->getLocale());
        }

        return $request;
    }

    /**
     * Create an ApiRequest from current request.
     * Useful for passing a form data to the api
     *
     * @param Request $request
     * @param string $uri
     * @param array $query
     * @param array $options
     * @return ApiRequest
     */
    protected function createApiRequestFromRequest(
        Request $request,
        $uri,
        $query = array(),
        $options = array()
    )
    {
        $options = array_replace(array(
            'param_name'    => null,
            'method'        => $request->getMethod(),
            'remove_token'  => '_token'
        ), $options);
        $req = $this->createApiRequest($uri, $query);
        $req->setMethod($options['method']);

        $param_name = $options['param_name'];
        $params = $param_name !== null ? $request->request->get($param_name) : $request->request->all();
        if (($token_field = $options['remove_token'])) {
            unset($params[ $token_field ]);
        }
        if ($params) {
            $req->setParameters($params);
        }

        $files = array_filter($param_name !== null ? $request->files->get($param_name) : $request->files->all());
        if ($files) {
            $req->getFilesBag()->replace($files);
        }

        return $req;
    }
}

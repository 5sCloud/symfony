<?php

namespace CsCloud\CoreBundle\Controller;
use Symfony\Component\HttpFoundation\Response;

use CsCloud\CoreBundle\Services\Util\ApiManager;
use CsCloud\CoreBundle\Services\Util\ApiRequest;

use CsCloud\CoreBundle\Exception\InvalidApiResponseException;
use CsCloud\CoreBundle\Exception\ApiErrorException;

use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;

/**
 * Description of ApiTrait
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
    protected function gewtApiManager()
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
}

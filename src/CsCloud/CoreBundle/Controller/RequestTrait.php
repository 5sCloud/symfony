<?php

namespace CsCloud\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use CsCloud\CoreBundle\Util\Url;

/**
 * Trait containing helper functions to handle Request object
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
trait RequestTrait
{
    /**
     * Get the query string from request
     * @param Request $request
     * @param boolean $absolute
     * @return string
     */
    public function getQueryString(Request $request, $absolute = false)
    {
        $url = new Url($request->getUri());
        if (!$absolute) {
            $url->host = null;
            $url->scheme = null;
        }

        return $url->toString();
    }

    /**
     * Returns TRUE if the request is generated from local connection
     * @param Request $request
     * @return boolean
     */
    public function isLocalRequest(Request $request)
    {
        $clientIp = $request->getClientIp();

        return $clientIp === '127.0.0.1';
    }
}

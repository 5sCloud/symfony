<?php

namespace CsCloud\ApiBundle\Security;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

use CsCloud\CoreBundle\Util\Url;

/**
 * Description of LogoutSuccessHandler
 *
 * @author alekitto
 */
class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    protected $httpUtils;
    protected $targetUrl;

    /**
     * @param HttpUtils $httpUtils
     * @param string    $targetUrl
     */
    public function __construct(HttpUtils $httpUtils, $targetUrl = '/')
    {
        $this->httpUtils = $httpUtils;
        $this->targetUrl = $targetUrl;
    }

    /**
     * {@inheritDoc}
     */
    public function onLogoutSuccess(Request $request)
    {
        if (($url = $request->query->get('return_url'))) {
            $redirect_url = new Url($url);
        } else {
            $redirect_url = new Url($this->httpUtils->generateUri($request, $this->targetUrl));
        }

        return new RedirectResponse($redirect_url->toString());
    }
}

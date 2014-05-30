<?php

namespace CsCloud\FrontendBundle\Security;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContextInterface;

use CsCloud\CoreBundle\Util\Url;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;

/**
 * Description of LogoutSuccessHandler
 *
 * @author alekitto
 */
class LogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    protected $httpUtils;
    protected $targetUrl;
    protected $apiLogoutUrl;
    protected $context;

    /**
     * @param HttpUtils $httpUtils
     * @param string    $targetUrl
     */
    public function __construct(HttpUtils $httpUtils, SecurityContextInterface $context,
        $apiLogoutUrl, $targetUrl = '/')
    {
        $this->httpUtils = $httpUtils;
        $this->targetUrl = $targetUrl;
        $this->apiLogoutUrl = $apiLogoutUrl;
        $this->context = $context;
    }

    /**
     * {@inheritDoc}
     */
    public function onLogoutSuccess(Request $request)
    {
        $target = $this->httpUtils->generateUri($request, $this->targetUrl);
        $token = $this->context->getToken();
        if ($token instanceof OAuthToken && $token->getResourceOwnerName() === 'cscloud') {
            $redirect_url = new Url($this->apiLogoutUrl);
            $redirect_url->setQueryParameter('return_url', $target);
        } else {
            $redirect_url = new Url($target);
        }

        return new RedirectResponse($redirect_url->toString());
    }
}

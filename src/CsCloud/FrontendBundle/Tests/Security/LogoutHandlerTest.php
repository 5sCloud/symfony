<?php

namespace CsCloud\FrontendBundle\Tests\Security;

use CsCloud\FrontendBundle\Security\LogoutSuccessHandler;

class LogoutHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogoutSuccess()
    {
        $httpUtils = mock('Symfony\Component\Security\Http\HttpUtils');
        $httpUtils->mockReturn('generateUri', 'http://m5s.local/app_dev.php/');

        $token = mock('Symfony\Component\Security\Core\Authentication\Token\AnonymousToken');
        $context = mock('Symfony\Component\Security\Core\SecurityContextInterface');
        $context->mockReturn('getToken', $token);

        $handler = new LogoutSuccessHandler($httpUtils, $context, 'http://api.m5s.local/app_dev.php/oauth/v2/auth_logout', '/');
        $response = $handler->onLogoutSuccess(mock('Symfony\Component\HttpFoundation\Request'));

        $this->assertEquals($response->getTargetUrl(), 'http://m5s.local/app_dev.php/');

        $token = mock('HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken')
                        ->mockReturn('getResourceOwnerName', 'facebook');
        $context->mockReturn('getToken', $token);

        $handler = new LogoutSuccessHandler($httpUtils, $context, 'http://api.m5s.local/app_dev.php/oauth/v2/auth_logout', '/');
        $response = $handler->onLogoutSuccess(mock('Symfony\Component\HttpFoundation\Request'));

        $this->assertEquals($response->getTargetUrl(), 'http://m5s.local/app_dev.php/');

        $token = mock('HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken')
                        ->mockReturn('getResourceOwnerName', 'cscloud');
        $context->mockReturn('getToken', $token);

        $handler = new LogoutSuccessHandler($httpUtils, $context, 'http://api.m5s.local/app_dev.php/oauth/v2/auth_logout', '/');
        $response = $handler->onLogoutSuccess(mock('Symfony\Component\HttpFoundation\Request'));

        $this->assertEquals($response->getTargetUrl(), 'http://api.m5s.local/app_dev.php/oauth/v2/auth_logout?return_url=http%3A%2F%2Fm5s.local%2Fapp_dev.php%2F');
    }
}

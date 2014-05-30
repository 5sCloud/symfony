<?php

namespace CsCloud\ApiBundle\Tests\Security;
use CsCloud\ApiBundle\Security\LogoutSuccessHandler;
use Symfony\Component\HttpFoundation\ParameterBag;

class LogoutSuccessHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogoutSuccess()
    {
        $httpUtils = mock('Symfony\Component\Security\Http\HttpUtils');
        $httpUtils->mockReturn('generateUri', 'http://api.m5s.local/app_dev.php/');

        $request = mock('Symfony\Component\HttpFoundation\Request');
        $request->query = new ParameterBag();

        $handler = new LogoutSuccessHandler($httpUtils, "/");
        $response = $handler->onLogoutSuccess($request);
        $this->assertEquals($response->getTargetUrl(), 'http://api.m5s.local/app_dev.php/');

        $request->query->set('return_url', 'http://example.org/');
        $response = $handler->onLogoutSuccess($request);
        $this->assertEquals($response->getTargetUrl(), 'http://example.org/');
    }
}

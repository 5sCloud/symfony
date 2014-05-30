<?php

namespace CsCloud\CoreBundle\Tests\Services\Util;

use CsCloud\CoreBundle\Services\Util\ApiRequest;
use CsCloud\CoreBundle\Services\Util\ApiManager;

class ApiManagerTest extends \PHPUnit_Framework_TestCase
{
    use \FBMock_AssertionHelpers;

    public function setUp()
    {
        $this->kernel = mock('Symfony\Component\HttpKernel\KernelInterface');
        $this->stack = mock('Symfony\Component\HttpFoundation\RequestStack');
        $this->context = mock('Symfony\Component\Security\Core\SecurityContextInterface');

        $this->manager = new ApiManager($this->kernel, $this->stack, $this->context, 'api.m5s.local');
    }

    /**
     * @dataProvider performRequestDataProvider
     */
    public function testPerformRequest($content_type, $serverError, $clientError,
            $successful, $request, $status_code, $exception, $content)
    {
        if ($exception) {
            $this->setExpectedException($exception);
        }

        $last_request = null;
        $response = mock('Symfony\Component\HttpFoundation\Response');
        $response->headers = new \Symfony\Component\HttpFoundation\ParameterBag();
        $response->headers->set('Content-Type', $content_type);
        $response
                ->mockReturn('isServerError', $serverError)
                ->mockReturn('isClientError', $clientError)
                ->mockReturn('isSuccessful', $successful)
                ->mockReturn('getStatusCode', $status_code)
                ->mockReturn('getContent', $content)
        ;

        $this->kernel->mockImplementation('handle', function($request) use(&$last_request, $response) {
            $last_request = $request;
            return $response;
        });

        $returned = $this->manager->performRequest($request);

        $this->assertEquals($returned, $response);
        $this->assertNumCalls($this->kernel, 'handle', 1);
    }

    public function performRequestDataProvider()
    {
        $datas = array();

        $request = new ApiRequest('/');
        $datas[] = array('text/html', false, false, true, $request, 200, "CsCloud\CoreBundle\Exception\InvalidApiResponseException", null);
        $datas[] = array('text/html', true, false, false, $request, 500, "CsCloud\CoreBundle\Exception\InvalidApiResponseException", null);
        $datas[] = array('application/json', true, false, false, $request, 500, "CsCloud\CoreBundle\Exception\InvalidApiResponseException", null);
        $datas[] = array('application/json', false, true, false, $request, 404, "Symfony\Component\HttpKernel\Exception\HttpException", '{"message": "Not Found"}');
        $datas[] = array('application/json', false, false, true, $request, 200, null, '{"data": "Example data"}');
        $datas[] = array('application/json', false, false, false, $request, 100, "CsCloud\CoreBundle\Exception\ApiErrorException", '{"data": "Example data"}');

        $request = new ApiRequest('/');
        $request->setSafe(true);
        $datas[] = array('text/html', false, false, true, $request, 200, "CsCloud\CoreBundle\Exception\InvalidApiResponseException", null);
        $datas[] = array('application/json', true, false, false, $request, 500, "CsCloud\CoreBundle\Exception\InvalidApiResponseException", null);
        $datas[] = array('application/json', false, true, false, $request, 404, null, '{"message": "Not Found"}');

        $request = new ApiRequest('/');
        $request->setSafeCodes(array(400, 404));
        $datas[] = array('text/html', false, false, true, $request, 200, "CsCloud\CoreBundle\Exception\InvalidApiResponseException", null);
        $datas[] = array('application/json', true, false, false, $request, 500, "CsCloud\CoreBundle\Exception\InvalidApiResponseException", null);
        $datas[] = array('application/json', false, true, false, $request, 404, null, '{"message": "Not Found"}');
        $datas[] = array('application/json', false, true, false, $request, 400, null, '{"message": "Bad Request"}');
        $datas[] = array('application/json', false, true, false, $request, 401, "Symfony\Component\HttpKernel\Exception\HttpException", '{"message": "Unauthorized"}');

        return $datas;
    }
}

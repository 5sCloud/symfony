<?php

namespace CsCloud\CoreBundle\Services\Util;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

use Symfony\Component\Security\Core\SecurityContextInterface;
use HWI\Bundle\OAuthBundle\Security\Core\Authentication\Token\OAuthToken;

use CsCloud\CoreBundle\Exception\InvalidApiResponseException;
use CsCloud\CoreBundle\Exception\ApiErrorException;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Process requests, make subrequest to the kernel and process response
 *
 * @author Alessandro Chitolina <alekitto@gmail.com>
 */
class ApiManager
{
    /**
     * The kernel that handles the sub-request(s)
     * @var KernelInterface
     */
    protected $kernel;

    /**
     * The request stack service
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * Current env api domain
     * @var string
     */
    protected $api_domain;

    /**
     * Current security context
     * @var SecurityContextInterface
     */
    protected $security_context;

    public function __construct(KernelInterface $app, RequestStack $stack,
        SecurityContextInterface $security_context, $api_domain)
    {
        $this->kernel = $app;
        $this->requestStack = $stack;
        $this->api_domain = $api_domain;
        $this->security_context = $security_context;
    }

    /**
     * Perform a kernel subrequest
     *
     * @param ApiRequest $request
     * @return Response
     */
    public function performRequest(ApiRequest $request)
    {
        // Prepare server variables array
        // Inherit Accept-Language and Accept-Charset from the current request (if set)
        $acceptLanguage = 'en-us,en;q=0.5';
        $acceptCharset = 'utf-8,ISO-8859-1;q=0.7;q=0.7,*';
        if (($currentRequest = $this->requestStack->getCurrentRequest())) {
            $acceptLanguage = $currentRequest->server->get('HTTP_ACCEPT_LANGUAGE', $acceptLanguage);
            $acceptCharset = $currentRequest->server->get('HTTP_ACCEPT_CHARSET', $acceptCharset);
        }

        /*
        $options = array();
        $token = $this->security_context->getToken();
        if ($token instanceof OAuthToken) {
            $options['auth'] = new \CsCloud\CoreBundle\Util\Requests_Auth_Bearer($token->getAccessToken());
        }
        \Requests::request($request->getUrl(), $parameters, $headers, $data, $acceptLanguage, $options);
         *
         */

        $server = array_replace(array(
            'SERVER_NAME'          => 'localhost',
            'SERVER_PORT'          => 80,
            'HTTP_HOST'            => $this->api_domain,
            'HTTP_USER_AGENT'      => 'Symfony/2.X',
            'HTTP_ACCEPT'          => 'application/json,application/xml,text/html,application/xhtml+xml;q=0.9,*/*;q=0.8',
            'HTTP_ACCEPT_LANGUAGE' => $acceptLanguage,
            'HTTP_ACCEPT_CHARSET'  => $acceptCharset,
            'REMOTE_ADDR'          => '127.0.0.1',
            'SCRIPT_NAME'          => '',
            'SCRIPT_FILENAME'      => '',
            'SERVER_PROTOCOL'      => 'HTTP/1.1',
            'REQUEST_TIME'         => time(),
        ), $request->getServerBag()->all());

        // Create and perform the request
        $subrequest = Request::create(
            $request->getUrl(),
            $request->getMethod(),
            $request->getParameterBag()->all(),
            $request->getCookiesBag()->all(),
            $request->getFilesBag()->all(),
            $server,
            $request->getContent()
        );
        $subrequest->setLocale($request->getLocale());
        $response = $this->kernel->handle($subrequest, \Symfony\Component\HttpKernel\HttpKernelInterface::SUB_REQUEST);

        // Check the content-type header (must be a json)
        if($response->headers->get('Content-Type') !== 'application/json') {
            throw new InvalidApiResponseException('Content-Type header mismatching (' .
                    $response->headers->get('Content-Type') . ' expected: application/json)');
        }

        if ($response->isServerError()) {
            throw new InvalidApiResponseException('Internal server error during API request');
        }

        if ($response->isClientError()) {
            if (!$request->isSafe() && !$request->isSafeFor($response->getStatusCode())) {
                $content = json_decode($response->getContent());
                throw new HttpException(
                    $response->getStatusCode(),
                    isset($content->message) ? $content->message : null
                    );
            }
        } elseif (!$response->isSuccessful()) {
            throw new ApiErrorException('API request not OK', $response);
        }

        return $response;
    }
}

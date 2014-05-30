<?php

namespace CsCloud\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use FOS\OAuthServerBundle\Security\Authentication\Token\OAuthToken;

abstract class BaseControllerTestCase extends WebTestCase
{
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function request($method, $uri, $access_token = null, array $parameters = array(), array $files = array(), array $server = array(), $content = null)
    {
        $domain = $this->client->getContainer()->getParameter('api_domain');

        $server = array_merge(array('HTTP_ACCEPT' => 'application/json', 'HTTP_HOST' => $domain), $server);

        if (null !== $access_token) {
            $server['HTTP_AUTHORIZATION'] = 'Bearer ' . $access_token;
        }

        $this->client->request($method, $uri, $parameters, $files, $server, $content);
        return $this->client->getResponse();
    }

    /**
     * Creates a fake user and oauth token for api
     */
    protected function getAccessToken()
    {
        $url = new \CsCloud\CoreBundle\Util\Url('/oauth/v2/token');
        $url->setQueryParameters(array(
            'grant_type' => 'password',
            'client_id'  => $this->client->getContainer()->getParameter('oauth_client_id'),
            'client_secret' => $this->client->getContainer()->getParameter('oauth_client_secret'),
            'username'   => 'admin',
            'password'   => 'admin'
        ));

        $response = $this->request("GET", $url->toString());
        $response = json_decode($response->getContent());

        return $response->access_token;
    }
}

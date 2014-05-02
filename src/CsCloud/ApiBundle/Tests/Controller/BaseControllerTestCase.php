<?php

namespace CsCloud\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseControllerTestCase extends WebTestCase
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function request($method, $uri, array $parameters = array(), array $files = array(), array $server = array(), $content = null)
    {
        $client = static::createClient();
        $domain = $client->getContainer()->getParameter('api_domain');

        $server = array_merge(array('HTTP_ACCEPT' => 'application/json', 'HTTP_HOST' => $domain), $server);
        $client->request($method, $uri, $parameters, $files, $server, $content);
        return $client->getResponse();
    }
}

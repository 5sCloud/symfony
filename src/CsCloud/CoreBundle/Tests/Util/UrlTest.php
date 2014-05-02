<?php

namespace CsCloud\CoreBundle\Tests\Util;

use CsCloud\CoreBundle\Util\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function testEmptyUrlException()
    {
        $this->setExpectedException("LogicException");
        new Url("");
    }

    public function testInvalidException()
    {
        $this->setExpectedException("LogicException");
        new Url("//:invalid");
    }

    public function testCompleteUrlParsing()
    {
        $url = new Url("https://usr:pswd@example.org:552/path/segment?q1=%20query&r2[]=d1&r2[]=d2#fragment");
        $this->assertEquals($url->getScheme(), "https");
        $this->assertEquals($url->getHost(), "example.org");
        $this->assertEquals($url->username, "usr");
        $this->assertEquals($url->password, "pswd");
        $this->assertEquals($url->port, 552);
        $this->assertEquals($url->path, "/path/segment");

        // Url-encoded query string
        $this->assertEquals($url->queryString, "q1=%20query&r2%5B0%5D=d1&r2%5B1%5D=d2");
        $this->assertEquals($url->getQueryParameters(), array(
            "q1" => " query",
            "r2" => array(
                "d1",
                "d2"
            )
        ));
        $this->assertEquals($url->fragment, "fragment");
    }

    public function testSetQueryParameter()
    {
        $url = new Url("http://test.example.org/?param=one");
        $url->setQueryParameter("parameter", "two");
        $this->assertEquals($url->getQueryParameters(), array(
            "param" => "one",
            "parameter" => "two"
        ));
        $this->assertEquals($url->queryString, "param=one&parameter=two");

        $url = new Url("http://test.example.org/");
        $url->setQueryParameter("params", "foobar");
        $this->assertEquals($url->getQueryParameters(), array(
            "params" => "foobar"
        ));
    }

    public function testSetQueryString()
    {
        $url = new Url("http://test.example.org/?param=one");
        $url->setQuery("q=query+parameters&oq=query%20parameters&ie=UTF-8");
        $this->assertEquals($url->getQueryParameters(), array(
            "q" => "query parameters",
            "oq" => "query parameters",
            "ie" => "UTF-8"
        ));
    }

    public function testSetQueryParameters()
    {
        $url = new Url("http://test.example.org/?param=one");
        $url->setQueryParameters(array(
            "q" => "query parameters",
            "oq" => "query parameters",
            "ie" => "UTF-8"
        ));

        // query parameters are reordered
        $this->assertEquals($url->queryString, "ie=UTF-8&oq=query%20parameters&q=query%20parameters");
    }

    public function testToString()
    {
        $url = new Url("https://usr:pswd@example.org:552/path/segment?q1=%20query&r2[]=d1&r2[]=d2#fragment");
        $this->assertEquals($url->toString(), "https://usr:pswd@example.org:552/path/segment?q1=%20query&r2%5B0%5D=d1&r2%5B1%5D=d2#fragment");

        $url->port = 443;
        $this->assertEquals($url->toString(), "https://usr:pswd@example.org/path/segment?q1=%20query&r2%5B0%5D=d1&r2%5B1%5D=d2#fragment");

        $url->scheme = "http";
        $this->assertEquals($url->toString(), "http://usr:pswd@example.org:443/path/segment?q1=%20query&r2%5B0%5D=d1&r2%5B1%5D=d2#fragment");
    }
}

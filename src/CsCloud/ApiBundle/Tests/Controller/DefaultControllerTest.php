<?php

namespace CsCloud\ApiBundle\Tests\Controller;

class DefaultControllerTest extends BaseControllerTestCase
{
    public function testIndex()
    {
        $response = $this->request("GET", "/");

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->headers->get('Content-Type'), "application/json");

        $response = json_decode($response->getContent());
        $this->assertNotNull($response);
        $this->assertNotEmpty($response);
    }
}

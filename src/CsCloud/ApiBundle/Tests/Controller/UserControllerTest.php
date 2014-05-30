<?php

namespace CsCloud\ApiBundle\Tests\Controller;

class UserControllerTest extends BaseControllerTestCase
{
    public function testUserInformation()
    {
        $access_token = $this->getAccessToken();
        $response = $this->request("GET", "/user/info", $access_token);

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals($response->headers->get('Content-Type'), "application/json");

        $response = json_decode($response->getContent());
        $this->assertNotNull($response);
        $this->assertNotEmpty($response);

        $this->assertEquals($response->id, 1);
        $this->assertEquals($response->username, "admin");
        $this->assertEquals($response->email, "admin@m5s.local");
    }
}

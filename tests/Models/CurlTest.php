<?php


namespace Models;

use App\Models\BaseTestClass;
use App\Models\Curl;

class CurlTest extends BaseTestClass
{
    private $curl;

    public function __construct()
    {
        parent::__construct();
        $this->curl = curl_init();
    }

    public function testSetOptStart()
    {
        Curl::setOptStart($this->curl);
        $this->assertNotEmpty(curl_getinfo($this->curl));
    }

    public function testSetOptUrlCurl()
    {
        $uri = "http://localhost:8080/v1/user";
        Curl::setOptUrlCurl($this->curl, $uri);
        $this->assertNotEmpty(curl_getinfo($this->curl));
    }

    public function testCloseCurl()
    {
        Curl::closeCurl($this->curl);
        $this->assertNotEmpty($this->curl);
    }
}
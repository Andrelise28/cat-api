<?php


namespace Traits;


use App\Models\BaseTestClass;
use App\Traits\GenerateUrl;

class GenerateUrlTest extends BaseTestClass
{
    use GenerateUrl;

    public function testGenerateUrlForRoutes()
    {
        $this->assertNotNull($this->generateUrlForRoutes());
    }

    public function testGenerateUrl()
    {
        $this->assertNotNull($this->generateUrl());
    }
}
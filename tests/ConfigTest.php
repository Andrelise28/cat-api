<?php

use App\Models\BaseTestClass;
use App\Models\Setting;

class ConfigTest extends BaseTestClass
{

    public function testSettings()
    {
        $configTest = new Setting();
        $this->assertNotEmpty($configTest->getSettings());
    }
}
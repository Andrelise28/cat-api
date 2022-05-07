<?php

use App\Models\BaseTestClass;

class BootstrapTest extends BaseTestClass
{
    public function testBootstrap()
    {
        $file = require __DIR__ . '/../bootstrap/app.php';
        $this->assertNotEmpty($file);
    }
}
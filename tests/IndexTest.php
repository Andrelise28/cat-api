<?php
use App\Models\BaseTestClass;


class IndexTest  extends BaseTestClass

{
    /**
     * @test
     */
    public function testIndexFile()
    {
        require __DIR__ . '/../bootstrap/app.php';
        $file = require __DIR__ . '/../public/index.php';
        $this->assertNotEmpty($file);
    }
}
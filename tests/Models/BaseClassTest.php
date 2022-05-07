<?php


namespace Models;


use App\Models\BaseTestClass;
use PHPUnit\Framework\TestCase;

class BaseClassTest extends TestCase
{
    private $newAnonymousClass;

    public function setUp(): void
    {
        parent::setUp();

        $this->newAnonymousClass = new class extends BaseTestClass {

            public function returnThis()
            {
                return $this;
            }
        };
    }

    public function testAbstractClass()
    {
        $this->assertInstanceOf(BaseTestClass::class, $this->newAnonymousClass->returnThis());
    }

    public function testRequestFactory()
    {
        $this->assertIsObject($this->newAnonymousClass->requestFactory());
    }

}
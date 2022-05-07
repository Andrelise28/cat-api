<?php


namespace Models;

use \App\Models\BaseTestClass;
use App\Models\Token;

class TokenTest extends BaseTestClass
{
    public function testGetToken()
    {
        $token = new Token(10);
        $this->assertEquals(10, $token->getToken()["uid"]);
    }
}
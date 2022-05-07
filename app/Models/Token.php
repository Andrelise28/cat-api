<?php


namespace App\Models;

class Token
{
    private $id;

    public function __construct($userId)
    {
        $this->id = $userId;
    }

    public function getToken()
    {
        $nowSeconds = time();
        return array(
            "iat" => $nowSeconds,
            "exp" => $nowSeconds+3600,
            "uid" => $this->id,
        );
    }
}
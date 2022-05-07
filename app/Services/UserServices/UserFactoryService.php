<?php


namespace App\Services\UserServices;

use App\Models\Crypto;
use App\Models\User;

class UserFactoryService
{

    public function create(array $dataUser)
    {
        $crypto = new Crypto();

        $user = new User();
        $user->name = $dataUser['name'];
        $user->email = $dataUser['email'];
        $user->password = $crypto->encrypt($dataUser['password']);
        $user->save();
        $crypto->saveCrypto($crypto, $user->id);
        return $user;
    }


}
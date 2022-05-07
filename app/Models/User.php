<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

    private const DIGITS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*';
    private const MAX_LENGTH = 8;

    public static function checkEmailExists($email)
    {
        return User::where('email', '=', $email)->first() !== null;
    }

    public static function checkIdExists($id)
    {
        return User::where('id', '=', $id)->first() !== null;
    }

    public static function getUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    public static function validateUser($email, $password)
    {
        $user = self::getUserByEmail($email);

        if ($user !== null) {

            $crypto = new Crypto();
            $crypto->setPasswords($password, $user['password'], $user['id']);

            if ($crypto->match()) {
                return $user;
            }
        }
        return null;
    }

    public static function generatePassword()
    {
        return substr(str_shuffle(self::DIGITS), 1, self::MAX_LENGTH);
    }


}
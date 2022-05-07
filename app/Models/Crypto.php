<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Crypto extends Model
{

    protected const SHA = 'sha256';

    /** @var int */
    protected $sha2len = 32;

    /** @var int */
    protected $userId;

    /** @var string */
    protected $iv = '';

    /** @var string */
    private $key = '';
    
    /** @var string */
    protected $tag = '';

    /** @var bool */
    private $cypher = false;

    /** @var string */
    private $userPassword = '';

    /** @var string */
    private $dbPassword = '';

    /** @var bool */
    private $passIsSet = false;

    protected $fillable = ['user_id', 'key'];

    public function __construct()
    {
        parent::__construct();
        $this->setIv();
        $this->setKey();
    }

    public function getPassIsSet()
    {
        return $this->passIsSet;
    }

    private function setKey()
    {
        $this->key = $this->generateKey();
    }

    private function setIv()
    {
        $this->iv = $this->generateKey();
    }

    public function encrypt($string)
    {
        if (empty($string)) {
            return '';
        }

        $hashString = hash_hmac(self::SHA, $string, $this->key, true);
        return base64_encode($this->iv . $hashString . $string);
    }

    private function decrypt($string, $userKey)
    {
        $len = 16;
        $decodeString = base64_decode($string);
        $hmac = substr($decodeString, $len, $this->sha2len);
        $cipherPassRaw = substr($decodeString, $len + $this->sha2len);
        $calcHash = hash_hmac(self::SHA, $cipherPassRaw, $userKey, true);

        if (hash_equals($hmac, $calcHash)) {
            $this->userPassword = hash_hmac(self::SHA, $this->userPassword, $userKey, true);
            if(hash_equals($hmac, $this->userPassword)) {
                $this->cypher = true;
            }
        }

        return $this->cypher;
    }

    public function setPasswords($userPassword, $dbPassword, $userId)
    {
        $this->userPassword = $userPassword;
        $this->dbPassword = $dbPassword;
        $this->userId = $userId;
        $this->passIsSet = true;
    }

    private function verifyPassword()
    {
        $userKey = Crypto::where('user_id', '=', $this->userId)->first();
        return $this->decrypt($this->dbPassword, $userKey['user_key']);
    }

    public function match()
    {
        return $this->passIsSet ? $this->verifyPassword() : $this->passIsSet;
    }

    public function saveCrypto($crypto, $userId)
    {
        $crypto->user_key = $this->key;
        $crypto->user_id = $userId;
        $crypto->save();
        return $crypto;
    }

    private function generateKey()
    {
        $digits  = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@#$%^&*';
        $maxLength = 16;
        return substr(str_shuffle($digits), 1, $maxLength);
    }

}
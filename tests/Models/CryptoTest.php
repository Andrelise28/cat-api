<?php


namespace Models;

use App\Models\BaseTestClass;
use App\Models\Crypto;
use App\Models\User;
use App\Services\UserServices\UserFactoryService;

class CryptoTest extends BaseTestClass
{

    private $crypto;

    public function __construct()
    {
        parent::__construct();
        $this->crypto = new Crypto();
    }

    public function testMathFalse()
    {
        $this->assertEquals(false, $this->crypto->match());
    }

    public function testMathTrue()
    {
        $pass = User::generatePassword();
        $user = $this->setUser($pass);
        $this->crypto->setPasswords($pass, $user['password'], $user['id']);
        $this->assertEquals(true, $this->crypto->match());
    }

    private function setUser($pass)
    {
        $dataUser = [
            'name' => 'teste',
            'email' => 'teste_crypto@teste.com.br',
            'password' => $pass
        ];
        $userFactoryService = new UserFactoryService();
        return $userFactoryService->create($dataUser);
    }

    public function testEncrypt()
    {
        $pass = 'test';
        $result = $this->crypto->encrypt($pass);
        $this->assertNotEmpty($result);
    }

    public function testGetPassIsSet()
    {
        $this->assertFalse($this->crypto->getPassIsSet());
    }

    public function testSetPasswords()
    {
        $this->crypto->setPasswords('', '', -10);
        $this->assertEquals(true, $this->crypto->getPassIsSet());
    }

    public function testSaveCrypto()
    {
        $newCrypto = new Crypto();
        $result = $newCrypto->saveCrypto($newCrypto, 999);
        $this->assertEquals(999, $result['user_id']);
    }

    public function testEncryptFail()
    {
        $result = $this->crypto->encrypt('');
        $this->assertEquals('', $result);
    }

    public function testForVerify()
    {
        $result = $this->crypto->match();
        $this->assertFalse($result);
    }
}
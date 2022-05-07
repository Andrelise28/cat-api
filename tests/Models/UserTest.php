<?php


namespace Models;


use App\Models\BaseTestClass;
use App\Models\User;
use App\Services\UserServices\UserFactoryService;
use App\Services\UserServices\UserService;

class UserTest extends BaseTestClass
{

    const PASS ="password";
    const NAME ="name";
    const EMAIL ="email";
    const ID ="id";

    private $params;

   
    public function setUp(): void
    {
        parent::setUp();
        $this->params = [
            self::NAME=> 'user test',
            self::EMAIL => 'user_test@teste.com.br'
        ];
    }

    private function createUserForTest()
    {
        $userFactory = new UserFactoryService();
        $userFactory->create($this->params);
    }

    /**
     * @test
     */
    public function testValidateUserEmailValid()
    {
        $this->params[self::PASS] = User::generatePassword();
        $this->createUserForTest();
        $result = User::validateUser($this->params[self::EMAIL], $this->params[self::PASS]);
        $this->assertEquals($this->params[self::NAME], $result[self::NAME]);
        $this->assertEquals($this->params[self::EMAIL], $result[self::EMAIL]);
    }

    /**
     * @test
     */
    public function testValidateUserEmailInvalid()
    {
        $result = User::validateUser('abc@teste.com.br', '');
        $this->assertEquals(null, $result);
    }

    /**
     * @test
     */
    public function testCheckEmailExistsTest()
    {

        $result = User::checkEmailExists($this->params[self::EMAIL]);
        $this->assertEquals(true, $result);
    }

    /**
     * @test
     */
    public function testCheckIdExists()
    {
        $result = User::checkIdExists(-5);
        $this->assertEquals(false, $result);
    }

    /**
     * @test
     */
    public function testGeneratePassword()
    {
        $this->assertNotEmpty(User::generatePassword());
        $this->deleteUserTest($this->params[self::EMAIL]);
    }


    private function deleteUserTest($email)
    {
        $user = User::getUserByEmail($email);
        $userService = new UserService();
        $userService->deleteUser($user[self::ID]);
    }



}
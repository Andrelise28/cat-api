<?php


namespace Services;

use App\Models\BaseTestClass;
use App\Models\User;
use App\Services\UserServices\UserService;


class UserServiceTest extends BaseTestClass
{

    private $userService;
    private $userName;
    private $userEmail;
    private $userPassword;

    const NAME = "name";
    const EMAIL = "email";

    public function __construct()
    {
        parent::__construct();
        $this->userService = new UserService();
        $this->start();
    }

    private function start()
    {
        $this->userName = 'inovadora user service test';
        $this->userEmail = 'teste@inovadora.com.br';
        $this->userPassword = User::generatePassword();
    }

    /**
     * @test
     */
    public function testCreateUserEmailValid()
    {
        $input = [
            self::NAME => $this->userName,
            self::EMAIL => $this->userEmail,
            'password' => $this->userPassword
        ];

        $user = $this->userService->createUser($input);
        $this->assertEquals($this->userName, $user[self::NAME]);
        $this->assertEquals($this->userEmail, $user[self::EMAIL]);
    }

    /**
     * @test
     */
    public function testGetWrongUser()
    {
        $userGetWrong = $this->userService->showUser(-1);
        $this->assertEquals(false, $userGetWrong);
    }

    /**
     * @test
     */
    public function testGetCorrectUser()
    {
        $userId = User::getUserByEmail($this->userEmail);
        $showUser = $this->userService->showUser($userId['id']);
        $this->assertEquals($this->userName, $showUser[self::NAME]);
        $this->assertEquals($this->userEmail, $showUser[self::EMAIL]);
    }

    /**
     * @test
     */
    public function testGetAll()
    {
        $getUser = $this->userService->getAll();
        $this->assertNotEmpty($getUser, 'foram encontrados registros no banco de dados');// banco não está vazio
    }

    /**
     * @test
     */
    public function testUpdateFalseIdUser()
    {
        $userUpdateWrong = $this->userService->UpdateUser(-10, 'Maria');
        $this->assertEquals(false, $userUpdateWrong);
    }

    /**
     * @test
     */
    public function testUpdateUser()
    {
        $userId = User::getUserByEmail($this->userEmail);
        $userUpdate = $this->userService->UpdateUser($userId['id'], 'inovadora');
        $this->assertEquals(true, $userUpdate);

    }

    /**
     * @test
     */
    public function testCreateEmailAlreadyExist()
    {
        $input = [
            'name' => $this->userName,
            'email' => $this->userEmail,
            'password' => $this->userPassword
        ];
        $userCreateAlreadyExist = $this->userService->createUser($input);
        $this->assertEquals(false, $userCreateAlreadyExist);
    }

    /**
     * @test
     */
    public function testDeleteUserIdNotExist()
    {
        $userDeleteFalse = $this->userService->deleteUser(-20);
        $this->assertEquals(false, $userDeleteFalse);
    }

    /**
     * @test
     */
    public function testDeleteUserIdExist()
    {
        $userId = User::getUserByEmail($this->userEmail);
        $userDelete = $this->userService->deleteUser($userId['id']);
        $this->assertEquals(true, $userDelete);
    }


}
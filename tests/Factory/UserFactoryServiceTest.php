<?php


namespace Factory;

use App\Models\User;
use App\Models\BaseTestClass;
use App\Services\UserServices\UserFactoryService;


class UserFactoryServiceTest extends BaseTestClass
{

    private $userFactoryService;
    private $userName;
    private $userEmail;
    private $userPassword;

    public function __construct()
    {
        parent::__construct();
        $this->userFactoryService = new UserFactoryService();
        $this->start();
    }

    private function start()
    {
        $this->userName = 'inovadora Factory';
        $this->userEmail = 'testeFactory@inovadora.com.br';
        $this->userPassword = User::generatePassword();

    }

    /**
     * @test
     */
    public function testCreateUserFactoryService()
    {

        $dataUser = [
            'name' => $this->userName,
            'email' => $this->userEmail,
            'password' => $this->userPassword
        ];

        $userFactory = $this->userFactoryService->create($dataUser);

        $this->assertEquals($this->userName, $userFactory['name']);
        $this->assertEquals($this->userEmail, $userFactory['email']);
    }
}
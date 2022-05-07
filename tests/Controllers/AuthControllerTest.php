<?php


namespace Controllers;

use App\Controller\AuthController;
use App\Models\BaseTestClass;
use App\Models\User;
use App\Services\UserServices\UserFactoryService;
use App\Services\UserServices\UserService;
use Slim\Http\Response;

class AuthControllerTest extends BaseTestClass
{

    const PASS ="password";
    const NAME ="name";
    const EMAIL ="email";


    private $authController;
    private $params = [];

    public function __construct()
    {
        parent::__construct();
        $this->authController = new AuthController();
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->params = [
            self::NAME => 'auth user test',
            self::EMAIL => 'auth@teste.com.br',
           self::PASS => User::generatePassword()
        ];
    }

    /**
     * @test
     */
    public function testLoginWithoutParams()
    {
        $request = $this->requestFactory();
        $request = $request->withMethod('POST');
        $request = $request->withQueryParams($this->params);
        $response = new Response();
        $result = $this->authController->login($request, $response);
        $this->assertEquals(401, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function testLoginComplete()
    {
        $this->createUserForTest($this->params);
        $request = $this->requestFactory();
        $request = $request->withMethod('POST');
        $request = $request->withQueryParams($this->params);
        $response = new Response();
        $result = $this->authController->login($request, $response);

        $this->deleteUserTest($this->params[self::EMAIL]);
        $this->assertEquals(200, $result->getStatusCode());
    }

    private function createUserForTest($dataArray)
    {
        $input = array (
            'name' => $dataArray[self::NAME],
            'email' => $dataArray[self::EMAIL],
            'password' => $dataArray[self::PASS]
        );

        $userFactory = new UserFactoryService();
        $userFactory->create($input);
    }

    private function deleteUserTest($email)
    {
        $user = User::getUserByEmail($email);
        $userService = new UserService();
        $userService->deleteUser($user['id']);
    }

}

<?php
namespace Controllers;
use App\Controller\UserController;
use App\Models\BaseTestClass;
use App\Models\User;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

class UserControllerTest extends BaseTestClass
{
    const PASS ="password";
    const NAME ="name";
    const EMAIL ="email";

    private $params = [];
    private $userController;
    private $args = [];

    public function __construct()
    {
        parent::__construct();
        $this->userController = new UserController();
    }


    public function setUp(): void
    {
        parent::setUp();
        $this->params = [
            'name' => ' userCreate',
            'email' => 'user@testeCreate.com.br',
            'password' => User::generatePassword()
        ];
        $this->args['id'] = -1;
    }

    /**
     * @test
     */
    public function testConstruct()
    {
        $usersController = new UserController();
        $this->assertInstanceOf(UserController::class, $usersController);
    }

    /**
     * @test
     */
    public function testCreateNoInput()
    {
        $environment = Environment::mock([]);
        $request = Request::createFromEnvironment($environment);
        $response = new Response();
        $result = $this->userController->create($request, $response);
        $this->assertEquals(402, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function testCreateUser()
    {
        $request = $this->requestFactory();
        $request = $request->withMethod('POST');
        $request = $request->withQueryParams($this->params);
        $response = new Response();
        $result = $this->userController->create($request, $response);
        $this->assertEquals(200, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function testCreateAlreadyExistEmailUser()
    {
        $request = $this->requestFactory();
        $request = $request->withMethod('POST');
        $request = $request->withQueryParams($this->params);
        $response = new Response();
        $result = $this->userController->create($request, $response);
        $this->assertEquals(402, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function testShowUser()
    {
        $request = $this->requestFactory();
        $userId = User::getUserByEmail($this->params[self::EMAIL]);
        $request = $request->withMethod('GET');

        $response = new Response();
        $result = $this->userController->show($request, $response, $userId);
        $result = $result->getBody()->__toString();
        $data = json_decode($result, true);

        $this->assertEquals($this->params[self::NAME], $data[self::NAME]);
        $this->assertEquals($this->params[self::EMAIL], $data[self::EMAIL]);
    }

    /**
     * @test
     */
    public function testShowIdNotExist()
    {
        $request = $this->requestFactory();
        $response = new Response();
        $result = $this->userController->show($request, $response,$this->args);
        $this->assertEquals(402, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function testGetAll()
    {
        $request = $this->requestFactory();
        $response = new Response();
        $result = $this->userController->getAll($request, $response);
        $this->assertEquals(200, $result->getStatusCode());
    }


    /**
     * @test
     */
    public function testUpdateUser()
    {
        $request = $this->requestFactory();
        $request = $request->withMethod('PUT');
        $param = [ 'name' => 'teste update user'];
        $user = User::getUserByEmail($this->params[self::EMAIL]);
        $request = $request->withQueryParams($param);
        $response = new Response();
        $result = $this->userController->update($request, $response,$user);
        $this->assertEquals(200, $result->getStatusCode());

    }

    /**
     * @test
     */
    public function testUpdateIdNotExist()
    {
        $request = $this->requestFactory();
        $request = $request->withMethod('POST');
        $request = $request->withQueryParams($this->params);
        $response = new Response();
        $result = $this->userController->update($request, $response,$this->args);
        $this->assertEquals(402, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function testDeleteNotExist()
    {
        $request = $this->requestFactory();
        $response = new Response();
        $result = $this->userController->delete($request, $response,$this->args);
        $this->assertEquals(402, $result->getStatusCode());
    }

    /**
     * @test
     */
    public function testDeleteUser()
    {
        $request = $this->requestFactory();
        $userId = User::getUserByEmail($this->params[self::EMAIL]);
        $request = $request->withMethod('DELETE');
        $response = new Response();
        $result = $this->userController->delete($request, $response, $userId);
        $this->assertEquals(200, $result->getStatusCode());
    }
}
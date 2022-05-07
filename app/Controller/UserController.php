<?php


namespace App\Controller;

use App\Services\UserServices\UserService;
use Slim\Http\Request;
use Slim\Http\Response;


class UserController
{
    private $userService;
    private const MESSAGE = 'Mensagem';

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function create(Request $request, Response $response)
    {
        $params = $request->getParams();

        if (empty($params['email']) || empty($params['password'])) {
            return $response->withJson([self::MESSAGE => 'Falha no cadastro do usuário, email ou senha não inseridos'], 402);
        }

        $user = $this->userService->createUser($params);

        if ($user === false) {
            return $response->withJson([self::MESSAGE => 'Falha no cadastro de usuário, email já utilizado'], 402);
        }

        return $response->withJson([self::MESSAGE => 'Usuário cadastrado', 'user' => $user], 200);
    }

    public function show(Request $request, Response $response, $args)
    {
        $request->getHeaders();
        if (!$this->userService->showUser($args['id'])) {
            return $response->withJson([self::MESSAGE => 'Valor do id inexistente'], 402);
        }

        return $response->withJson($this->userService->showUser($args['id']));
    }

    public function update(Request $request, Response $response, $args)
    {
        $params = $request->getParams();

        if (!$this->userService->UpdateUser($args['id'], $params['name'])) {
            return $response->withJson([self::MESSAGE => 'Falha em alterar usuário'], 402);
        }

        return $response->withJson([self::MESSAGE => 'Usuário alterado com sucesso!'], 200);
    }

    public function delete(Request $request, Response $response, $args)
    {
        $request->getHeaders();
        if (!$this->userService->deleteUser($args['id'])) {
            return $response->withJson([self::MESSAGE => 'Valor do id inexistente'], 402);
        }

        return $response->withJson([self::MESSAGE => 'Usuário deletado'], 200);

    }

    public function getAll(Request $request, Response $response)
    {
        $request->getHeaders();
        return $response->withJson($this->userService->getAll());
    }

}
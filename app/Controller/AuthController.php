<?php


namespace App\Controller;

use App\Models\Token;
use Slim\Http\Response;
use Slim\Http\Request;
use App\Models\User;
use Firebase\JWT\JWT;


class AuthController
{
    private const ALG = 'HS256';

    public function login(Request $request, Response $response)
    {
        $params = $request->getParams();
        $user = User::validateUser($params['email'], $params['password']);

        if($user === null){
            return $response->withJson(['message' => 'Falha no login, email ou senha incorretos'], 401);
        }

        $token = new Token($user['id']);

        $jwt = JWT::encode($token->getToken(), getenv("JWT_SECRET"), self::ALG);
        JWT::$leeway = 120;

        return $response->withJson(['message' => 'Login autorizado', 'User' => $user['name'],
            'JWT' => $jwt], 200);
    }


}
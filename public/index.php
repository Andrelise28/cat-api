<?php

require_once __DIR__ . "/../bootstrap/app.php";

use App\Controller\AuthController;
use App\Controller\UserController;
use App\Controller\CatBreedsController;
use Slim\Http\Response;
use Tuupola\Middleware\JwtAuthentication;
use App\Traits\GenerateUrl;

const LOGIN_URL = "/v1/auth/login";
const CREATE_URL = "/v1/user/create";

$app->group('/v1', function () {
    $this->group('/auth', function () {
        $this->post('/login', AuthController::class . ':login');
    });

    $this->group('/user', function () {
        $this->post('/create', UserController::class . ':create');
        $this->delete('/delete/{id}', UserController::class . ':delete');
        $this->get('/show/{id}', UserController::class . ':show');
        $this->post('/update/{id}', UserController::class . ':update');
        $this->get('', UserController::class . ':getAll');

    });

    $this->group('/breeds', function () {
        $this->get('', CatBreedsController::class . ':breeds');
        $this->get('/search', CatBreedsController::class . ':search');
    });
});

$app->add(new JwtAuthentication([
    "regexp" => "/(.*)/",
    "header" => "X-Token",
    "ignore" => [LOGIN_URL, CREATE_URL],
    "secret" => getenv("JWT_SECRET"),
    "error" => function(Response $response) {
        return $response->withJson(['message' => 'JWT Inválida'], 401);
    },
    "secure" => true,
    "relaxed" => ["localhost", GenerateUrl::generateUrlForRoutes()]
]));

$app->run();


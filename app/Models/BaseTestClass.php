<?php

namespace App\Models;

use App\Traits\GenerateUrl;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Capsule\Manager;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\RequestBody;
use Slim\Http\Uri;


abstract class BaseTestClass extends TestCase
{
    use GenerateUrl;

    private $config;

    public function __construct()
    {
        parent::__construct();
        $this->config = new Setting();
        $this->loadManager();
    }

    private function loadManager()
    {
        $capsule = new Manager();
        $capsule->addConnection($this->config->getSettings()['settings']['database']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }

   public function requestFactory()
    {
        $env = Environment::mock();
        $uri = Uri::createFromString($this->generateUrl());
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        $request =  new Request('GET', $uri, $headers, $cookies, $serverParams, $body);
        return $request->withHeader('Content-Type', 'multipart/form-data; boundary=<calculated when request is sent>');
    }


}
<?php


namespace Services;


use App\Models\BaseTestClass;
use App\Services\DatabaseServices\EloquentServiceProvider;
use Slim\App;


class EloquentServiceProviderTest extends BaseTestClass
{
    private $app;
    public function __construct()
    {
        parent::__construct();
        $config = require __DIR__ . '/../../config/config.php';
        $this->app = new App($config);
    }

    public function testRegister()
    {
        $container = $this->app->getContainer();
        $eloquentService = new EloquentServiceProvider();
        $eloquentService->register($container);
        $this->assertNotEmpty($container);
    }
}
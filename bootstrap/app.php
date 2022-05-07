<?php

use Slim\App;
use App\Services\DatabaseServices\EloquentServiceProvider;
use App\Models\Setting;

require_once __DIR__ . "/../vendor/autoload.php";

$config = new Setting();
$app = new App($config->getSettings());

$container = $app->getContainer();
$container->register(new EloquentServiceProvider());





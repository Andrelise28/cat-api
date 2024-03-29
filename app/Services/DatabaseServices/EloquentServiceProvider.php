<?php
namespace App\Services\DatabaseServices;

use Illuminate\Database\Capsule\Manager;
use Pimple\Container;
use Pimple\ServiceProviderInterface;


class EloquentServiceProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $container A container instance
     */
    public function register(Container $container)
    {
        $capsule = new Manager();
        $capsule->addConnection($container['settings']['database']);
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }
}
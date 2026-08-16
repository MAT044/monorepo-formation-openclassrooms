<?php

use TomTroc\Core\DependencyContainer\DependencyContainer;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Router\Router;
use TomTroc\Core\Router\RouterFactory;

require dirname(__DIR__) . '/autoload.php';

$container = new DependencyContainer(
    [
        Router::class => fn() => RouterFactory::fromConfigPath(dirname(__DIR__) . '/config/routes.php')->create()
    ]
);

$router = $container->resolve(Router::class);

$router->handleRequest(Request::fromGlobals());
<?php

use TomTroc\Core\DependencyContainer\DependencyContainer;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Router\Router;

require dirname(__DIR__) . '/autoload.php';

$container = new DependencyContainer(require dirname(__DIR__) . '/config/container.php');

$router = $container->resolve(Router::class);

$router->handleRequest(Request::fromGlobals());
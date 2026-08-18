<?php

use TomTroc\Core\DependencyContainer\DependencyContainer;
use TomTroc\Core\Http\Request;
use TomTroc\Core\Router\Router;

require dirname(__DIR__) . '/autoload.php';

if (preg_match('/\.(?:png|jpg|jpeg|gif|svg|css|js)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve the requested resource as-is.
}

$container = new DependencyContainer(require dirname(__DIR__) . '/config/container.php');

$router = $container->resolve(Router::class);

$router->handleRequest(Request::fromGlobals());
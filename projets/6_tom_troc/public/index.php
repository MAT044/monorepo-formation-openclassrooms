<?php

use TomTroc\Core\Http\Request;
use TomTroc\Core\Router\RouterFactory;

require dirname(__DIR__) . '/autoload.php';

$router = RouterFactory::fromConfigPath(dirname(__DIR__) . '/config/routes.php')->create();

$router->handleRequest(Request::fromGlobals());
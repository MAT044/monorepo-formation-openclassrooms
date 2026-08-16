<?php

use TomTroc\Core\Http\Request;
use TomTroc\Core\Router\Router;

require dirname(__DIR__) . '/autoload.php';

$router = new Router();

$router->handleRequest(Request::fromGlobals());
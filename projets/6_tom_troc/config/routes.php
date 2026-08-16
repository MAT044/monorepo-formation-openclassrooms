<?php

use TomTroc\Controller\HomeController;
use TomTroc\Core\Router\Router;

return function(Router $router) {
    $router->get('app_home', '/', [HomeController::class, 'index']);
    $router->get('app_home', '/home', [HomeController::class, 'index']);
};
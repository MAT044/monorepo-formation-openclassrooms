<?php

use TomTroc\Controller\HomeController;
use TomTroc\Controller\UserController;
use TomTroc\Core\Router\Router;

return function(Router $router) {
    $router->get('app_home', '/', [HomeController::class, 'index']);
    $router->all('app_user_login', '/connexion', [UserController::class, 'login']);
    $router->all('app_user_register', '/inscription', [UserController::class, 'register']);
    $router->all('app_user_account', '/mon-compte', [UserController::class, 'account']);
};
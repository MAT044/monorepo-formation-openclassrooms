<?php

use TomTroc\Controller\HomeController;
use TomTroc\Core\Router\Router;

return function(Router $router) {
    $router->get('app_home', '/', fn() => (new HomeController())->index());
    $router->get('app_home', '/home', fn() => (new HomeController())->index());
};
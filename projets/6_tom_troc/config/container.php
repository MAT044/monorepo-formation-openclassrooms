<?php

use TomTroc\Controller\UserController;
use TomTroc\Core\DependencyContainer\DependencyContainer;
use TomTroc\Core\Router\Router;
use TomTroc\Core\Router\RouterFactory;
use TomTroc\Core\TemplateEngine\TemplateEngine;
use TomTroc\Infrastructure\Repository\SessionUserRepository;
use TomTroc\Model\Repository\UserRepository;

return [
        Router::class => fn(DependencyContainer $container) => RouterFactory::fromConfigPath(__DIR__ . '/routes.php')->create($container),
        TemplateEngine::class => fn() => new TemplateEngine(dirname(__DIR__) . '/templates/'),
        UserController::class => fn(DependencyContainer $container) => new UserController(
                $container->resolve(UserRepository::class)
        ),
        UserRepository::class => fn(DependencyContainer $container) => $container->resolve(SessionUserRepository::class)
];
<?php

use TomTroc\Controller\BookController;
use TomTroc\Controller\MessageController;
use TomTroc\Controller\UserController;
use TomTroc\Core\DependencyContainer\DependencyContainer;
use TomTroc\Core\Router\Router;
use TomTroc\Core\Router\RouterFactory;
use TomTroc\Core\TemplateEngine\TemplateEngine;
use TomTroc\Infrastructure\Repository\SessionBookRepository;
use TomTroc\Infrastructure\Repository\SessionMessageRepository;
use TomTroc\Infrastructure\Repository\SessionUserRepository;
use TomTroc\Model\Repository\BookRepository;
use TomTroc\Model\Repository\MessageRepository;
use TomTroc\Model\Repository\UserRepository;

return [
        Router::class => fn(DependencyContainer $container) => RouterFactory::fromConfigPath(__DIR__ . '/routes.php')->create($container),
        TemplateEngine::class => fn() => new TemplateEngine(dirname(__DIR__) . '/templates/'),
        UserController::class => fn(DependencyContainer $container) => new UserController(
                $container->resolve(UserRepository::class),
                $container->resolve(BookRepository::class)
        ),
        UserRepository::class => fn(DependencyContainer $container) => $container->resolve(SessionUserRepository::class),
        BookController::class  => fn(DependencyContainer $container) => new BookController(
                $container->resolve(BookRepository::class),
                $container->resolve(UserRepository::class)
        ),
        BookRepository::class => fn(DependencyContainer $container) => $container->resolve(SessionBookRepository::class),
        MessageController::class => fn(DependencyContainer $container) => new MessageController(
                $container->resolve(MessageRepository::class),
                $container->resolve(UserRepository::class)
        ),
        MessageRepository::class => fn(DependencyContainer $container) => $container->resolve(SessionMessageRepository::class),
];
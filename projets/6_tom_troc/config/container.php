<?php

use TomTroc\Controller\BookController;
use TomTroc\Controller\HomeController;
use TomTroc\Controller\MessageController;
use TomTroc\Controller\UserController;
use TomTroc\Core\DB\DB;
use TomTroc\Core\DependencyContainer\DependencyContainer;
use TomTroc\Core\Router\Router;
use TomTroc\Core\Router\RouterFactory;
use TomTroc\Core\TemplateEngine\TemplateEngine;
use TomTroc\Infrastructure\Repository\DbBookRepository;
use TomTroc\Infrastructure\Repository\DbMessageRepository;
use TomTroc\Infrastructure\Repository\DbUserRepository;
use TomTroc\Model\Repository\BookRepository;
use TomTroc\Model\Repository\MessageRepository;
use TomTroc\Model\Repository\UserRepository;

return [
        DB::class => function() {
                $config = parse_ini_file(__DIR__ . '/db.ini');
                return new DB(
                        $config['DB_NAME'] ?? 'tomtroc',
                        $config['DB_USER'] ?? 'root',
                        $config['DB_PASSWORD'] ?? '',
                        $config['DB_HOST'] ?? '127.0.0.1',
                        (int) ($config['DB_PORT'] ?? 3306)
                );
        },
        Router::class => fn(DependencyContainer $container) => RouterFactory::fromConfigPath(__DIR__ . '/routes.php')->create($container),
        TemplateEngine::class => fn() => new TemplateEngine(dirname(__DIR__) . '/templates/'),
        HomeController::class => fn(DependencyContainer $container) => new HomeController(
                $container->resolve(BookRepository::class)
        ),
        UserController::class => fn(DependencyContainer $container) => new UserController(
                $container->resolve(UserRepository::class),
                $container->resolve(BookRepository::class)
        ),
        UserRepository::class => fn(DependencyContainer $container) => new DbUserRepository(
                $container->resolve(DB::class)
        ),
        BookController::class  => fn(DependencyContainer $container) => new BookController(
                $container->resolve(BookRepository::class),
                $container->resolve(UserRepository::class)
        ),
        BookRepository::class => fn(DependencyContainer $container) => new DbBookRepository(
                $container->resolve(DB::class)
        ),
        MessageController::class => fn(DependencyContainer $container) => new MessageController(
                $container->resolve(MessageRepository::class),
                $container->resolve(UserRepository::class)
        ),
        MessageRepository::class => fn(DependencyContainer $container) => new DbMessageRepository(
                $container->resolve(DB::class),
                $container->resolve(UserRepository::class)
        ),
];
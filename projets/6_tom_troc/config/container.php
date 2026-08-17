<?php

use TomTroc\Core\Router\Router;
use TomTroc\Core\Router\RouterFactory;
use TomTroc\Core\TemplateEngine\TemplateEngine;

return [
        Router::class => fn($container) => RouterFactory::fromConfigPath(__DIR__ . '/routes.php')->create($container),
        TemplateEngine::class => fn() => new TemplateEngine(dirname(__DIR__) . '/templates/')
];
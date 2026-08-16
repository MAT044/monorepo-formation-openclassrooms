<?php

use TomTroc\Core\Router\Router;
use TomTroc\Core\Router\RouterFactory;

return [
        Router::class => fn($container) => RouterFactory::fromConfigPath(__DIR__ . '/routes.php')->create($container)
];
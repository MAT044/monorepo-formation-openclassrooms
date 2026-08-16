<?php

namespace TomTroc\Core\Router;

use Closure;
use TomTroc\Core\DependencyContainer\DependencyContainer;

readonly class RouterFactory {

    public function __construct(private Closure $configClosure){}

    public function create(DependencyContainer $container) {
        $router = new Router($container);
        ($this->configClosure)($router);
        return $router;
    }

    public static function fromConfigPath(string $configPath)
    {
        return new self(require $configPath);
    }
}
<?php

namespace TomTroc\Core\Router;

use Closure;

readonly class RouterFactory {

    public function __construct(private Closure $configClosure){}

    public function create() {
        $router = new Router();
        ($this->configClosure)($router);
        return $router;
    }

    public static function fromConfigPath(string $configPath)
    {
        return new self(require $configPath);
    }
}
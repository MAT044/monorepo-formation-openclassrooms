<?php

namespace TomTroc\Core\Router;

use Closure;
use TomTroc\Core\Http\Method;

class Route {
    public function __construct(
        public readonly string $name,
        public readonly string $path,
        public readonly Closure $controller,
        public readonly Method $httpMethod
    ){}
}
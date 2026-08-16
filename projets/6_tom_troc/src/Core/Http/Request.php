<?php

namespace TomTroc\Core\Http;

class Request {
    public function __construct(
        public readonly Method $method,
        public readonly string $uri,
        public readonly array $query,
        public readonly array $body,
    ){}

    public function get(string $name, mixed $default = null)
    {
        return $this->body[$name] ?? $this->query[$name] ?? $default;
    }
    
    public static function fromGlobals(): Request
    {
        return new Request(
            Method::from($_SERVER['REQUEST_METHOD']),
            $_SERVER['REQUEST_URI'],
            $_GET,
            $_POST
        );
    }
}
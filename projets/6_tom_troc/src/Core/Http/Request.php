<?php

namespace TomTroc\Core\Http;

class Request {
    public function __construct(
        public readonly Method $method,
        public readonly string $uri,
        public readonly array $query,
        public readonly array $body,
        public readonly array $files = [],
    ){}

    public function get(string $name, mixed $default = null)
    {
        return $this->body[$name] ?? $this->query[$name] ?? $default;
    }

    public function file(string $name, mixed $default = null): ?array
    {
        return $this->files[$name] ?? $default;
    }
    
    public static function fromGlobals(): Request
    {
        return new Request(
            Method::from($_SERVER['REQUEST_METHOD']),
            strtok($_SERVER['REQUEST_URI'], '?'),
            $_GET,
            $_POST,
            $_FILES
        );
    }

    public function mergeQuery(array $params): Request {
        return new Request(
            $this->method,
            $this->uri,
            array_merge($this->query, $params),
            $this->body,
            $this->files
        );
    }
}
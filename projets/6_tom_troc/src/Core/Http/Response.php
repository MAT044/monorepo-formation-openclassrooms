<?php

namespace TomTroc\Core\Http;

class Response {
    public function __construct(
        public readonly int $code,
        public readonly string $body,
        public readonly array $headers = []
    )
    {}
}
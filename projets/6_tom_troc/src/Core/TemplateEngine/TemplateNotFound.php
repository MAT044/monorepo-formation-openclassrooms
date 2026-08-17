<?php

namespace TomTroc\Core\TemplateEngine;

use Exception;


class TemplateNotFound extends Exception {
     public function __construct(string $name) {
        parent::__construct("Template ". $name ." not found", 500);
    }
}
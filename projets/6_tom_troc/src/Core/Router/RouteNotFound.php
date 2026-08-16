<?php

namespace TomTroc\Core\Router;

use Exception;

class RouteNotFound extends Exception {
    public function __construct() {
        parent::__construct("Route not found", 404);
    }
}
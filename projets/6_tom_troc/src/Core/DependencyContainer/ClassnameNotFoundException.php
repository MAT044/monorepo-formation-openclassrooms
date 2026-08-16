<?php

namespace TomTroc\Core\DependencyContainer;

use Exception;


class ClassnameNotFoundException extends Exception {
     public function __construct(string $name) {
        parent::__construct("Classname ". $name ." not found", 500);
    }
}
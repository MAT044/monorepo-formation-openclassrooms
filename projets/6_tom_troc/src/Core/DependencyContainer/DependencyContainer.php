<?php

namespace TomTroc\Core\DependencyContainer;


class DependencyContainer {
    private array $cache = [];

    public function __construct(
        private array $factories
    ){}

    public function resolve(string $classname) 
    {
        return $this->cache[$classname] ??=  $this->create($classname);
    }

    private function create(string $classname)
    {
        if(isset($this->factories[$classname])) {
            return ($this->factories[$classname])($this);
        }
        return new $classname;
    }
}
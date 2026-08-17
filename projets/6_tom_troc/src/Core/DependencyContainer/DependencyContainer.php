<?php

namespace TomTroc\Core\DependencyContainer;

class DependencyContainer
{
    private array $cache = [];

    public function __construct(
        private array $factories
    ) {
    }

    public function resolve(string $classname)
    {
        return $this->cache[$classname] ??= $this->postCreate($this->create($classname));
    }

    private function create(string $classname)
    {
        if (isset($this->factories[$classname])) {
            return ($this->factories[$classname])($this);
        }

        if (class_exists($classname)) {
            return new $classname;
        }

        throw new ClassnameNotFoundException($classname);
    }

    private function postCreate(mixed $object)
    {
        if($object instanceof ContainerAwareInterface) {
            $object->setContainer($this);
        }

        return $object;
    }
}
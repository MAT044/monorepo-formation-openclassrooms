<?php

namespace TomTroc\Core\DependencyContainer;

trait ContainerAwareTrait {
    private DependencyContainer $container;

    public function setContainer(DependencyContainer $container) {
        $this->container = $container;
    }

    protected function getContainer(): DependencyContainer {
        return $this->container;
    }
}
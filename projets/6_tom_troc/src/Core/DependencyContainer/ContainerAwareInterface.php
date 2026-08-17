<?php

namespace TomTroc\Core\DependencyContainer;

interface ContainerAwareInterface {
    public function setContainer(DependencyContainer $container);
}
<?php

namespace TomTroc\Core\Framework;

use TomTroc\Core\DependencyContainer\ContainerAwareInterface;
use TomTroc\Core\DependencyContainer\ContainerAwareTrait;
use TomTroc\Core\Http\Response;
use TomTroc\Core\TemplateEngine\TemplateEngine;

abstract class AbstractController implements ContainerAwareInterface {
    use ContainerAwareTrait;

    protected function view(string $classname, array $vars = []): Response
    {
        return $this->getContainer()->resolve($classname)->response($vars);
    }
}
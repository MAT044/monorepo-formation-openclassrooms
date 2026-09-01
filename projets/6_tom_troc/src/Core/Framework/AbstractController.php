<?php

namespace TomTroc\Core\Framework;

use TomTroc\Core\DependencyContainer\ContainerAwareInterface;
use TomTroc\Core\DependencyContainer\ContainerAwareTrait;
use TomTroc\Core\Http\Response;

abstract class AbstractController implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected function view(string $classname, array $vars = []): Response
    {
        return $this->getContainer()->resolve($classname)->response($vars);
    }

    protected function redirect(string $path): Response
    {
        return new Response(302, 'Redirect to ' . $path, ['Location: ' . $path]);
    }
}
<?php

namespace TomTroc\Core\Framework;

use TomTroc\Core\DependencyContainer\ContainerAwareInterface;
use TomTroc\Core\DependencyContainer\ContainerAwareTrait;
use TomTroc\Core\Http\Response;
use TomTroc\Core\TemplateEngine\TemplateEngine;

abstract class AbstractView implements ContainerAwareInterface {
    use ContainerAwareTrait;

    public function __construct(
        private readonly int $code = 200
    ){}

    public function response(array $params): Response
    {
        return new Response(
            code: $this->code,
            body: $this->renderBody($params)
        );
    }

    abstract protected function renderBody(array $vars = []): string;

    protected function render(?string $templateName, array $vars = []): string
    {
        if($templateName === null) {
            return '';
        }
        
        return $this->getTemplateEngine()->render($templateName, $vars);
    }

    private function getTemplateEngine(): TemplateEngine
    {
        return $this->getContainer()->resolve(TemplateEngine::class);
    }
}
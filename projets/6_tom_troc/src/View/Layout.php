<?php

namespace TomTroc\View;

use TomTroc\Core\Framework\AbstractView;

abstract class Layout extends AbstractView {

    public function __construct(
        private readonly int $code = 200,
        private readonly ?string $title = 'Default title',
        private readonly ?string $headerTemplate = 'includes/header',
        private readonly ?string $contentTemplate = null,
        private readonly ?string $footerTemplate = 'includes/footer',
    ){
        parent::__construct($code);
    }

    protected function renderBody(array $vars = []): string
    {
        return $this->render('layout', [
            'title' => $this->renderTitle($vars),
            'header' => $this->renderHeader($vars),
            'content' => $this->renderContent($vars),
            'footer' => $this->renderFooter($vars)
        ]);
    }

    protected function renderTitle(array $vars = []): string
    {
        return $vars['title'] ?? $this->title;
    }

    protected function renderHeader(array $vars = []): string
    {
        return $this->render($this->headerTemplate, $vars);
    }

    protected function renderContent(array $vars = []): string
    {
        return $this->render($this->contentTemplate, $vars);
    }

    protected function renderFooter(array $vars = []): string
    {
        return $this->render($this->footerTemplate, $vars);
    }
}
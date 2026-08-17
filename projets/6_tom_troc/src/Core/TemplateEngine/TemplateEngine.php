<?php

namespace TomTroc\Core\TemplateEngine;

class TemplateEngine {
    public function __construct(
        private readonly string $templatesFolder
    ){}

    public function render(string $templateName, array $vars = []) {
        $templatePath = $this->templatesFolder . $templateName . '.php';
        if (file_exists($templatePath)) {
            extract($vars);
            ob_start();
            require($templatePath);
            return ob_get_clean();
        } else {
            throw new TemplateNotFound($templateName);
        }
    }
}
<?php

declare(strict_types=1);

namespace App\Renderer;

use Framework\Render\PhpRenderer;

final readonly class PhpViewRenderer extends PhpRenderer
{
    public function __construct(
        private string $source,
    ) {
    }

    public function render(
        string $view,
        array $vars = [],
    ): string {
        return parent::render(
            rtrim($this->source, '/') . '/' . ltrim($view, '/'),
            $vars,
        );
    }
}

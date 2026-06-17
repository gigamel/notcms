<?php

declare(strict_types=1);

namespace Framework\Render\Contract;

interface RendererInterface
{
    public function render(
        string $view,
        array $vars = [],
    ): string;
}

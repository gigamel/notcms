<?php

declare(strict_types=1);

namespace Framework\Render;

use Framework\Render\Contract\RendererInterface;
use RuntimeException;

readonly class PhpRenderer implements RendererInterface
{
    public function render(
        string $view,
        array $vars = [],
    ): string {
        if (!is_file($view)) {
            throw new RuntimeException(sprintf(
                'View file %s does not exist',
                $view,
            ));
        }

        if (!is_readable($view)) {
            throw new RuntimeException(sprintf(
                'View file %s is not readable',
                $view,
            ));
        }

        if (!str_ends_with($view, '.php')) {
            throw new RuntimeException(sprintf(
                'View file %s does not end with .php',
                $view,
            ));
        }

        extract($vars);
        unset($vars);

        $level = ob_get_level();

        try {
            ob_start();
            require $view;
            return ob_get_clean();
        } finally {
            while (ob_get_level() > $level) {
                ob_end_clean();
            }
        }
    }
}

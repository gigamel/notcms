<?php

declare(strict_types=1);

namespace App\Controller;

use Framework\Http\Protocol\Response;
use Framework\Render\Contract\RendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class DefaultController implements RequestHandlerInterface
{
    public function __construct(
        private RendererInterface $renderer,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new Response($this->renderer->render(
            'home.php',
        ));
    }
}

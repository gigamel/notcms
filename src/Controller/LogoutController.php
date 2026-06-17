<?php

declare(strict_types=1);

namespace App\Controller;

use Framework\Http\Protocol\Response;
use Framework\Render\Contract\RendererInterface;
use Klax\Http\Protocol\Method;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class LogoutController implements RequestHandlerInterface
{
    public function __construct(
        private RendererInterface $renderer,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->isAuth()) {
            if ($request->getMethod() === Method::POST) {
                unset($_SESSION['is_auth']);
                return new Response('', 302, ['Location' => '/']);
            }

            return new Response($this->renderer->render('logout.php'));
        }

        return new Response('', 302, [
            'Location' => '/',
        ]);
    }

    private function isAuth(): bool
    {
        return $_SESSION['is_auth'] ?? false;
    }
}

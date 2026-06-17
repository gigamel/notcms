<?php

declare(strict_types=1);

namespace App\Controller;

use Framework\Http\Protocol\Response;
use Framework\Render\Contract\RendererInterface;
use Klax\Http\Protocol\Method;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class LoginController implements RequestHandlerInterface
{
    public function __construct(
        private RendererInterface $renderer,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->isAuth()) {
            return new Response('', 302, ['Location' => '/']);
        }

        if (!$this->isAuth() && $request->getMethod() === Method::POST) {
            if (
                'admin' === ($_POST['username'] ?? null)
                && '123' === ($_POST['password'] ?? null)
            ) {
                $_SESSION['is_auth'] = true;
                return new Response('', 302, ['Location' => '/']);
            }
        }

        return new Response($this->renderer->render(
            'login.php',
        ));
    }

    private function isAuth(): bool
    {
        return $_SESSION['is_auth'] ?? false;
    }
}

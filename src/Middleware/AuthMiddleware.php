<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\Http\Protocol\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final readonly class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private string $loginPageUri,
    ) {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        if ($this->isAuthorized()) {
            return $handler->handle($request);
        }

        if ($this->loginPageUri === $request->getUri()->getPath()) {
            return $handler->handle($request);
        }

        return new Response('', 302, ['Location' => $this->loginPageUri]);
    }

    private function isAuthorized(): bool
    {
        return $_SESSION['is_auth'] ?? false;
    }
}

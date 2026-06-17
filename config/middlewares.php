<?php

declare(strict_types=1);

use App\Middleware\AuthMiddleware;
use App\Middleware\StartupMiddleware;
use Klax\Http\Router\Contract\RouterInterface;
use Klax\Http\Runner\Factory\ThrowableHandlerFactory;
use Klax\Http\Runner\Middleware\RoutingMiddleware;
use Klax\Http\Runner\Middleware\ThrowableMiddleware;
use Psr\Container\ContainerInterface;

return [
    ThrowableMiddleware::class => static function (ContainerInterface $container): ThrowableMiddleware {
        return new ThrowableMiddleware(
            $container->get(ThrowableHandlerFactory::class),
        );
    },
    StartupMiddleware::class => StartupMiddleware::class,
    RoutingMiddleware::class => static fn (ContainerInterface $container): RoutingMiddleware
        => new RoutingMiddleware($container->get(RouterInterface::class)),
    AuthMiddleware::class => static fn (): AuthMiddleware => new AuthMiddleware('/login/'),
];

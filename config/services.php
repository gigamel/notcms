<?php

declare(strict_types=1);

use App\Middleware\AuthMiddleware;
use App\Middleware\StartupMiddleware;
use App\Renderer\PhpViewRenderer;
use Framework\Render\Contract\RendererInterface;
use Klax\Http\Router\Contract\RouteCollectionInterface;
use Klax\Http\Router\Contract\RouterInterface;
use Klax\Http\Router\RouteCollection;
use Klax\Http\Router\Router;
use Klax\Http\Runner\Contract\EmergencyThrowableHandlerInterface;
use Klax\Http\Runner\Contract\HttpRunnerInterface;
use Klax\Http\Runner\Contract\MainRequestHandlerInterface;
use Klax\Http\Runner\Contract\SapiEmitterInterface;
use Klax\Http\Runner\Factory\RequestHandlerFactory;
use Klax\Http\Runner\Factory\ThrowableHandlerFactory;
use Klax\Http\Runner\FallbackRequestHandler;
use Klax\Http\Runner\HttpRunner;
use Klax\Http\Runner\MainRequestHandler;
use Klax\Http\Runner\Middleware\RoutingMiddleware;
use Klax\Http\Runner\Middleware\ThrowableMiddleware;
use Klax\Http\Skeleton\Runner\EmergencyThrowableHandler;
use Klax\Http\Skeleton\Runner\SapiEmitter;
use Psr\Container\ContainerInterface;

return [
    RouterInterface::class => static function (ContainerInterface $container) {
        return new Router($container->get(RouteCollectionInterface::class));
    },
    RouteCollectionInterface::class => static function (): RouteCollectionInterface {
        $collection = new RouteCollection();
        (require_once('routes.php'))($collection);
        return $collection;
    },
    SapiEmitterInterface::class => SapiEmitter::class,
    RendererInterface::class => static function (): RendererInterface {
        return new PhpViewRenderer('../view');
    },
    ThrowableHandlerFactory::class => static function (ContainerInterface $container): ThrowableHandlerFactory {
        return new ThrowableHandlerFactory($container);
    },
    EmergencyThrowableHandlerInterface::class => EmergencyThrowableHandler::class,
    RequestHandlerFactory::class => static function (ContainerInterface $container): RequestHandlerFactory {
        return new RequestHandlerFactory($container);
    },
    FallbackRequestHandler::class => static function (ContainerInterface $container): FallbackRequestHandler {
        return new FallbackRequestHandler(
            $container->get(RequestHandlerFactory::class),
        );
    },
    MainRequestHandlerInterface::class => static function (ContainerInterface $container): MainRequestHandlerInterface {
        return new MainRequestHandler(
            $container->get(FallbackRequestHandler::class),
            [
                $container->get(ThrowableMiddleware::class),
                $container->get(StartupMiddleware::class),
                $container->get(RoutingMiddleware::class),
                $container->get(AuthMiddleware::class),
            ],
        );
    },
    HttpRunnerInterface::class => static function (ContainerInterface $container): HttpRunnerInterface {
        return new HttpRunner(
            $container->get(MainRequestHandlerInterface::class),
            $container->get(SapiEmitterInterface::class),
            $container->get(EmergencyThrowableHandlerInterface::class),
        );
    },
];

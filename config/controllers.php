<?php

declare(strict_types=1);

use App\Controller\DefaultController;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use Framework\Render\Contract\RendererInterface;
use Psr\Container\ContainerInterface;

return [
    DefaultController::class => static function (ContainerInterface $container): DefaultController {
        return new DefaultController(
            $container->get(RendererInterface::class),
        );
    },
    LoginController::class => static function (ContainerInterface $container): LoginController {
        return new LoginController(
            $container->get(RendererInterface::class),
        );
    },
    LogoutController::class => static function (ContainerInterface $container): LogoutController {
        return new LogoutController(
            $container->get(RendererInterface::class),
        );
    },
];

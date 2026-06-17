<?php

declare(strict_types=1);

use App\Controller\DefaultController;
use App\Controller\LoginController;
use App\Controller\LogoutController;
use Klax\Http\Router\Contract\RouteCollectionInterface;

return static function (RouteCollectionInterface $routes): void {

    $routes->add(
        'logout',
        '/logout/',
        LogoutController::class,
    );

    $routes->add(
        'login',
        '/login/',
        LoginController::class,
    );

    $routes->add(
        'home',
        '/',
        DefaultController::class,
    );

};

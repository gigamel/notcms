<?php

declare(strict_types=1);

use Klax\Container\Container;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$importServices = static function (string $file) use ($container): void
{
    if (!is_file($file) || !is_readable($file)) {
        throw new RuntimeException("Error reading services file '$file'");
    }

    foreach ((array)require($file) as $id => $service) {
        $container->singleton($id, $service);
    }
};

$importServices(__DIR__ . '/config/middlewares.php');
$importServices(__DIR__ . '/config/services.php');
$importServices(__DIR__ . '/config/controllers.php');

return $container;

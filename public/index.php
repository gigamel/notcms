<?php

declare(strict_types=1);

use Framework\Http\Factory\ServerRequestFactory;
use Klax\Http\Runner\Contract\HttpRunnerInterface;
use Psr\Container\ContainerInterface;

ini_set('display_errors', 1);
error_reporting(E_ALL);

/** @var ContainerInterface $container */
$container = require_once(__DIR__ . '/../bootstrap.php');
$container->get(HttpRunnerInterface::class)->run(ServerRequestFactory::fromGlobals());

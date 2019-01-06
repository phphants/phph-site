<?php
declare(strict_types=1);

Locale::setDefault('en_GB');

chdir(dirname(__DIR__));
require __DIR__ . '/../vendor/autoload.php';

/** @var \Interop\Container\ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

/** @var \Zend\Expressive\Application $app */
$app = $container->get(\Zend\Expressive\Application::class);
require 'config/pipeline.php';
require 'config/routes.php';
$app->run();

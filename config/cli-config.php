<?php
declare(strict_types = 1);

use Doctrine\ORM\Tools\Console\ConsoleRunner;

/** @var \Interop\Container\ContainerInterface $container */
$container = require __DIR__ . '/../config/container.php';

$entityManager = $container->get(\Doctrine\ORM\EntityManagerInterface::class);

return ConsoleRunner::createHelperSet($entityManager);

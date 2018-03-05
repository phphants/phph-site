<?php
declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

/** @var \Psr\Container\ContainerInterface $container */
$container = require __DIR__ . '/../../config/container.php';

$doctrine = $container->get(\Doctrine\ORM\EntityManagerInterface::class);
$doctrine->getConnection()->exec(file_get_contents(__DIR__ . '/sample-fixtures.sql'));

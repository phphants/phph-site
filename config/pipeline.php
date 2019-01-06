<?php
/**
 * Expressive middleware pipeline
 */

/** @var \Zend\Expressive\Application $app */
$app->pipe(\Zend\Stratigility\Middleware\OriginalMessages::class);
$app->pipe(\Zend\Stratigility\Middleware\ErrorHandler::class);
$app->pipe(\Zend\Expressive\Helper\ServerUrlMiddleware::class);
$app->pipe(\Zend\Expressive\Router\Middleware\RouteMiddleware::class);
$app->pipe(\Zend\Expressive\Router\Middleware\ImplicitHeadMiddleware::class);
$app->pipe(\Zend\Expressive\Router\Middleware\ImplicitOptionsMiddleware::class);
$app->pipe(\Zend\Expressive\Helper\UrlHelperMiddleware::class);
$app->pipe(\Zend\Expressive\Router\Middleware\DispatchMiddleware::class);
$app->pipe(\Zend\Expressive\Middleware\NotFoundHandler::class);

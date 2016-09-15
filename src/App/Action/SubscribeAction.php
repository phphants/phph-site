<?php
declare(strict_types = 1);

namespace App\Action;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Stratigility\MiddlewareInterface;

final class SubscribeAction implements MiddlewareInterface
{
    public function __invoke(Request $request, Response $response, callable $next = null) : RedirectResponse
    {
        return new RedirectResponse('http://eepurl.com/DaINX');
    }
}

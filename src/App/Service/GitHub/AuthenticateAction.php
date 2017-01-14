<?php
declare(strict_types = 1);

namespace App\Service\GitHub;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Stratigility\MiddlewareInterface;

final class AuthenticateAction implements MiddlewareInterface
{
    /**
     * @var GitHubAuthenticationInterface
     */
    private $authentication;

    public function __construct(GitHubAuthenticationInterface $authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        return new RedirectResponse($this->authentication->createRedirectUrl());
    }
}

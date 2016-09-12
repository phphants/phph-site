<?php
declare(strict_types = 1);

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class Authentication implements MiddlewareInterface
{
    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        TemplateRendererInterface $renderer
    ) {
        $this->authenticationService = $authenticationService;
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        if (!$this->authenticationService->hasIdentity()) {
            return new HtmlResponse($this->renderer->render('error/403'), 403);
        }

        return $out($request, $response);
    }
}

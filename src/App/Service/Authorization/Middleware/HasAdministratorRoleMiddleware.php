<?php
declare(strict_types = 1);

namespace App\Service\Authorization\Middleware;

use App\Service\Authorization\AuthorizationServiceInterface;
use App\Service\Authorization\Role\AdministratorRole;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class HasAdministratorRoleMiddleware implements MiddlewareInterface
{
    /**
     * @var AuthorizationServiceInterface
     */
    private $authorizationService;

    /**
     * @var TemplateRendererInterface
     */
    private $renderer;

    public function __construct(
        AuthorizationServiceInterface $authorizationService,
        TemplateRendererInterface $renderer
    ) {
        $this->authorizationService = $authorizationService;
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     * @throws \InvalidArgumentException
     */
    public function __invoke(Request $request, Response $response, callable $out = null) : Response
    {
        if (!$this->authorizationService->hasRole(new AdministratorRole())) {
            return new HtmlResponse($this->renderer->render('error/403'), 403);
        }

        return $out($request, $response);
    }
}

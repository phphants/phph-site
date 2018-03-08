<?php
declare(strict_types = 1);

namespace App\Action\Account;

use App\Service\Authentication\AuthenticationServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class UnlinkThirdPartyAuthenticationAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        EntityManagerInterface $entityManager,
        AuthenticationServiceInterface $authenticationService,
        UrlHelper $urlHelper
    ) {
        $this->entityManager = $entityManager;
        $this->authenticationService = $authenticationService;
        $this->urlHelper = $urlHelper;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param callable|null $next
     * @return RedirectResponse
     * @throws \App\Service\Authentication\Exception\NotAuthenticated
     * @throws \DomainException
     */
    public function __invoke(Request $request, Response $response, callable $next = null) : RedirectResponse
    {
        $this->entityManager->transactional(function () use ($request) {
            $this->authenticationService->getIdentity()->disassociateThirdPartyLoginByUuid(
                Uuid::fromString($request->getAttribute('loginId'))
            );
        });

        return new RedirectResponse($this->urlHelper->generate('account-settings'));
    }
}

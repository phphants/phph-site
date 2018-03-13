<?php
declare(strict_types=1);

namespace App\Action\Account\Settings;

use App\Service\Authentication\AuthenticationServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class DeleteMeHandler implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        UrlHelper $urlHelper,
        EntityManagerInterface $entityManager,
        AuthenticationServiceInterface $authenticationService
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->urlHelper = $urlHelper;
        $this->entityManager = $entityManager;
        $this->authenticationService = $authenticationService;
    }

    /**
     * {@inheritDoc}
     * @throws \InvalidArgumentException
     * @throws \App\Service\Authentication\Exception\NotAuthenticated
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        if ('POST' === strtoupper($request->getMethod())) {
            $this->entityManager->transactional(function () {
                $user = $this->authenticationService->getIdentity();
                $this->authenticationService->clearIdentity();
                $this->entityManager->remove($user);
            });

            // @todo add in some kind of feedback to the user, maybe use zend-expressive-flash
            return new RedirectResponse($this->urlHelper->generate('home'));
        }

        return new HtmlResponse($this->templateRenderer->render('account::settings/confirm-delete-me'));
    }
}

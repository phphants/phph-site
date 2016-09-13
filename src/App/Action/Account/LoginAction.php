<?php
declare(strict_types = 1);

namespace App\Action\Account;

use App\Service\Authentication\AuthenticationServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Stratigility\MiddlewareInterface;

final class LoginAction implements MiddlewareInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        TemplateRendererInterface $templateRenderer,
        UrlHelper $urlHelper
    ) {
        $this->templateRenderer = $templateRenderer;
        $this->authenticationService = $authenticationService;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $error = null;

        if ('POST' === strtoupper($request->getMethod())) {
            // @todo validate the form properly
            $data = $request->getParsedBody();

            if ($this->authenticationService->authenticate($data['email'], $data['password'])) {
                return new RedirectResponse($this->urlHelper->generate('account-dashboard'));
            }

            $error = 'Unable to authenticate';
        }

        return new HtmlResponse($this->templateRenderer->render('account::login', [
            'error' => $error,
        ]));
    }
}

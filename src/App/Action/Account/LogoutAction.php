<?php
declare(strict_types = 1);

namespace App\Action\Account;

use App\Service\Authentication\AuthenticationServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Stratigility\MiddlewareInterface;

final class LogoutAction implements MiddlewareInterface
{
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
        UrlHelper $urlHelper
    ) {
        $this->authenticationService = $authenticationService;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(Request $request, Response $response, callable $next = null) : Response
    {
        $this->authenticationService->clearIdentity();

        return new RedirectResponse($this->urlHelper->generate('account-login'));
    }
}

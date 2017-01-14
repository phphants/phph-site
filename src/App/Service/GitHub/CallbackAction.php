<?php
declare(strict_types = 1);

namespace App\Service\GitHub;

use App\Service\Authentication\AuthenticationServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Stratigility\MiddlewareInterface;

final class CallbackAction implements MiddlewareInterface
{
    /**
     * @var GitHubAuthenticationInterface
     */
    private $gitHubAuthentication;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        GitHubAuthenticationInterface $gitHubAuthentication,
        AuthenticationServiceInterface $authenticationService,
        UrlHelper $urlHelper
    ) {
        $this->gitHubAuthentication = $gitHubAuthentication;
        $this->authenticationService = $authenticationService;
        $this->urlHelper = $urlHelper;
    }

    /**
     * {@inheritdoc}
     * @throws \Zend\Expressive\Helper\Exception\RuntimeException
     * @throws \Zend\Expressive\Router\Exception\RuntimeException
     */
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
        $query = $request->getQueryParams();
        $thirdPartyAuthentication = $this->gitHubAuthentication->createThirdPartyAuthentication(
            $query['code'],
            $query['state']
        );

        if (!$this->authenticationService->thirdPartyAuthenticate($thirdPartyAuthentication)) {
            return new RedirectResponse($this->urlHelper->generate('account-login') . '?oauth_failed=1');
        }

        return new RedirectResponse($this->urlHelper->generate('account-dashboard'));
    }
}

<?php
declare(strict_types = 1);

namespace App\Service\Twitter;

use App\Service\Authentication\AuthenticationServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Stratigility\MiddlewareInterface;

final class CallbackAction implements MiddlewareInterface
{
    /**
     * @var TwitterAuthenticationInterface
     */
    private $twitterAuthentication;

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        TwitterAuthenticationInterface $twitterAuthentication,
        AuthenticationServiceInterface $authenticationService,
        UrlHelper $urlHelper
    ) {
        $this->twitterAuthentication = $twitterAuthentication;
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
        $thirdPartyAuthentication = $this->twitterAuthentication->createThirdPartyAuthentication(
            $query['oauth_token'],
            $query['oauth_verifier']
        );

        if (!$this->authenticationService->thirdPartyAuthenticate($thirdPartyAuthentication)) {
            return new RedirectResponse($this->urlHelper->generate('account-login') . '?oauth_failed=1');
        }

        return new RedirectResponse($this->urlHelper->generate('account-dashboard'));
    }
}

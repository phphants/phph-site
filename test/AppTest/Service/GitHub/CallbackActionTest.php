<?php
declare(strict_types = 1);

namespace AppTest\Service\GitHub;

use App\Entity\UserThirdPartyAuthentication\GitHub;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\GitHub\CallbackAction;
use App\Service\GitHub\GitHubAuthenticationInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @covers \App\Service\GitHub\CallbackAction
 */
class CallbackActionTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccessfulCallbackAuthentication()
    {
        $code = uniqid('code', true);
        $state = uniqid('state', true);
        $dashboardUrl = uniqid('/dashboard', true);

        $authData = ThirdPartyAuthenticationData::new(
            GitHub::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            []
        );

        /** @var GitHubAuthenticationInterface|\PHPUnit_Framework_MockObject_MockObject $github */
        $github = $this->createMock(GitHubAuthenticationInterface::class);
        $github->expects(self::once())
            ->method('createThirdPartyAuthentication')
            ->with($code, $state)
            ->willReturn($authData);

        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $auth */
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::once())
            ->method('thirdPartyAuthenticate')
            ->with($authData)
            ->willReturn(true);

        /** @var UrlHelper|\PHPUnit_Framework_MockObject_MockObject $urlHelper */
        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())->method('generate')->with('account-dashboard')->willReturn($dashboardUrl);

        $response = (new CallbackAction($github, $auth, $urlHelper))->__invoke(
            (new ServerRequest())
                ->withQueryParams([
                    'code' => $code,
                    'state' => $state,
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($dashboardUrl, $response->getHeaderLine('Location'));
    }

    public function testFailedAuthenticationRedirectsBackToLogin()
    {
        $code = uniqid('code', true);
        $state = uniqid('state', true);
        $loginUrl = uniqid('/login', true);

        $authData = ThirdPartyAuthenticationData::new(
            GitHub::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            []
        );

        /** @var GitHubAuthenticationInterface|\PHPUnit_Framework_MockObject_MockObject $github */
        $github = $this->createMock(GitHubAuthenticationInterface::class);
        $github->expects(self::once())
            ->method('createThirdPartyAuthentication')
            ->with($code, $state)
            ->willReturn($authData);

        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $auth */
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::once())
            ->method('thirdPartyAuthenticate')
            ->with($authData)
            ->willReturn(false);

        /** @var UrlHelper|\PHPUnit_Framework_MockObject_MockObject $urlHelper */
        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())->method('generate')->with('account-login')->willReturn($loginUrl);

        $response = (new CallbackAction($github, $auth, $urlHelper))->__invoke(
            (new ServerRequest())
                ->withQueryParams([
                    'code' => $code,
                    'state' => $state,
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($loginUrl . '?oauth_failed=1', $response->getHeaderLine('Location'));
    }
}

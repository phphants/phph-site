<?php
declare(strict_types = 1);

namespace AppTest\Service\Twitter;

use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\Twitter\CallbackAction;
use App\Service\Twitter\TwitterAuthenticationInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @covers \App\Service\Twitter\CallbackAction
 */
class CallbackActionTest extends \PHPUnit_Framework_TestCase
{
    public function testSuccessfulCallbackAuthentication()
    {
        $oauthToken = uniqid('oauthToken', true);
        $oauthVerifier = uniqid('oauthVerifier', true);
        $dashboardUrl = uniqid('/dashboard', true);

        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            []
        );

        /** @var TwitterAuthenticationInterface|\PHPUnit_Framework_MockObject_MockObject $twitter */
        $twitter = $this->createMock(TwitterAuthenticationInterface::class);
        $twitter->expects(self::once())
            ->method('createThirdPartyAuthentication')
            ->with($oauthToken, $oauthVerifier)
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

        $response = (new CallbackAction($twitter, $auth, $urlHelper))->__invoke(
            (new ServerRequest())
                ->withQueryParams([
                    'oauth_token' => $oauthToken,
                    'oauth_verifier' => $oauthVerifier,
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($dashboardUrl, $response->getHeaderLine('Location'));
    }

    public function testFailedAuthenticationRedirectsBackToLogin()
    {
        $oauthToken = uniqid('oauthToken', true);
        $oauthVerifier = uniqid('oauthVerifier', true);
        $loginUrl = uniqid('/login', true);

        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            uniqid('id', true),
            uniqid('email', true),
            uniqid('displayName', true),
            []
        );

        /** @var TwitterAuthenticationInterface|\PHPUnit_Framework_MockObject_MockObject $twitter */
        $twitter = $this->createMock(TwitterAuthenticationInterface::class);
        $twitter->expects(self::once())
            ->method('createThirdPartyAuthentication')
            ->with($oauthToken, $oauthVerifier)
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

        $response = (new CallbackAction($twitter, $auth, $urlHelper))->__invoke(
            (new ServerRequest())
                ->withQueryParams([
                    'oauth_token' => $oauthToken,
                    'oauth_verifier' => $oauthVerifier,
                ]),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($loginUrl . '?oauth_failed=1', $response->getHeaderLine('Location'));
    }
}

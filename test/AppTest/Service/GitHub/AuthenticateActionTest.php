<?php
declare(strict_types = 1);

namespace AppTest\Service\GitHub;

use App\Service\GitHub\AuthenticateAction;
use App\Service\GitHub\GitHubAuthenticationInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * @covers \App\Service\GitHub\AuthenticateAction
 */
class AuthenticateActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionReturnsRedirect()
    {
        $url = uniqid('/url', true);

        /** @var GitHubAuthenticationInterface|\PHPUnit_Framework_MockObject_MockObject $auth */
        $auth = $this->createMock(GitHubAuthenticationInterface::class);
        $auth->expects(self::once())->method('createRedirectUrl')->willReturn($url);

        $response = (new AuthenticateAction($auth))->__invoke(
            new ServerRequest(),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($url, $response->getHeaderLine('Location'));
    }
}

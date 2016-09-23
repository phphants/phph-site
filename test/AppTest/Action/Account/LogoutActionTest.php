<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\Account\LogoutAction;
use App\Service\Authentication\AuthenticationServiceInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @covers \App\Action\Account\LogoutAction
 */
final class LogoutActionTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeClearsIdentityAndRedirects()
    {
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::once())->method('clearIdentity');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-login')
            ->willReturn('/account/login');

        $response = (new LogoutAction($auth, $urlHelper))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/login', $response->getHeaderLine('Location'));
    }
}

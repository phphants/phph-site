<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\Account\LoginAction;
use App\Service\Authentication\AuthenticationServiceInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\LoginAction
 */
final class LoginActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRequestRendersTemplate()
    {
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::never())->method('authenticate');

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::login')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $response = (new LoginAction($auth, $renderer, $urlHelper))->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        self::markTestIncomplete('Validation not written yet');

        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::never())->method('authenticate');

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::login')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $response = (new LoginAction($auth, $renderer, $urlHelper))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody(['email' => '', 'password' => '']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestThatFailsAuthenticationRendersTemplate()
    {
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::once())
            ->method('authenticate')
            ->with('foo@bar.com', 'incorrect password')
            ->willReturn(false);

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::login')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $response = (new LoginAction($auth, $renderer, $urlHelper))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody(['email' => 'foo@bar.com', 'password' => 'incorrect password']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testValidPostRequestThatAuthenticatesReturnsRedirect()
    {
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::once())
            ->method('authenticate')
            ->with('foo@bar.com', 'incorrect password')
            ->willReturn(true);

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())
            ->method('generate')
            ->with('account-dashboard')
            ->willReturn('/account/dashboard');

        $response = (new LoginAction($auth, $renderer, $urlHelper))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody(['email' => 'foo@bar.com', 'password' => 'incorrect password']),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/dashboard', $response->getHeaderLine('Location'));
    }
}

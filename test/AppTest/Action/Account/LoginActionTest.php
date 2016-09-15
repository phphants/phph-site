<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\Account\LoginAction;
use App\Service\Authentication\AuthenticationServiceInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\Element\Text;
use Zend\Form\FormInterface;

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

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::never())->method('setData');
        $form->expects(self::never())->method('isValid');
        $form->expects(self::never())->method('getData');

        $response = (new LoginAction($auth, $renderer, $urlHelper, $form))->__invoke(
            (new ServerRequest(['/']))->withMethod('GET'),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }

    public function testInvalidPostRequestRendersTemplate()
    {
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::never())->method('authenticate');

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::login')->willReturn('content...');

        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::never())->method('generate');

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::once())->method('setData')->with(['email' => '', 'password' => '']);
        $form->expects(self::once())->method('isValid')->willReturn(false);
        $form->expects(self::never())->method('getData');

        $response = (new LoginAction($auth, $renderer, $urlHelper, $form))->__invoke(
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

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::once())->method('setData')->with([
            'email' => 'foo@bar.com',
            'password' => 'incorrect password',
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(true);
        $form->expects(self::once())->method('getData')->willReturn([
            'email' => 'foo@bar.com',
            'password' => 'incorrect password',
        ]);
        $form->expects(self::once())->method('get')->with('email')->willReturn(new Text());

        $response = (new LoginAction($auth, $renderer, $urlHelper, $form))->__invoke(
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

        $form = $this->createMock(FormInterface::class);
        $form->expects(self::once())->method('setData')->with([
            'email' => 'foo@bar.com',
            'password' => 'incorrect password',
        ]);
        $form->expects(self::once())->method('isValid')->willReturn(true);
        $form->expects(self::once())->method('getData')->willReturn([
            'email' => 'foo@bar.com',
            'password' => 'incorrect password',
        ]);

        $response = (new LoginAction($auth, $renderer, $urlHelper, $form))->__invoke(
            (new ServerRequest(['/']))
                ->withMethod('post')
                ->withParsedBody(['email' => 'foo@bar.com', 'password' => 'incorrect password']),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame('/account/dashboard', $response->getHeaderLine('Location'));
    }
}

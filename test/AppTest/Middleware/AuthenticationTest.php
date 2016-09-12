<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Middleware\Authentication;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Middleware\Authentication
 */
final class AuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testMiddlewareReturns403WhenNotAuthenticated()
    {
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::once())->method('hasIdentity')->willReturn(false);

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('error/403')->willReturn('content...');

        $nextMiddleware = $this->getMockBuilder(\stdClass::class)->setMethods(['__invoke'])->getMock();
        $nextMiddleware->expects(self::never())->method('__invoke');

        $response = (new Authentication($auth, $renderer))->__invoke(
            new ServerRequest(['/']),
            new Response(),
            $nextMiddleware
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
        self::assertSame(403, $response->getStatusCode());
    }

    public function testMiddlewareContinuesPipeWhenAuthenticated()
    {
        $auth = $this->createMock(AuthenticationServiceInterface::class);
        $auth->expects(self::once())->method('hasIdentity')->willReturn(true);

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $finalResponse = new Response();

        $nextMiddleware = $this->getMockBuilder(\stdClass::class)->setMethods(['__invoke'])->getMock();
        $nextMiddleware->expects(self::once())->method('__invoke')->with(
            self::isInstanceOf(ServerRequest::class),
            self::isInstanceOf(Response::class)
        )->willReturn($finalResponse);

        $response = (new Authentication($auth, $renderer))->__invoke(
            new ServerRequest(['/']),
            new Response(),
            $nextMiddleware
        );

        self::assertSame($finalResponse, $response);
    }
}

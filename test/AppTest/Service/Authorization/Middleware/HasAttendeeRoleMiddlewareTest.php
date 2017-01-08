<?php
declare(strict_types = 1);

namespace AppTest\Service\Authorization\Middleware;

use App\Service\Authorization\AuthorizationServiceInterface;
use App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware;
use App\Service\Authorization\Role\AttendeeRole;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Service\Authorization\Middleware\HasAttendeeRoleMiddleware
 */
class HasAttendeeRoleMiddlewareTest extends \PHPUnit_Framework_TestCase
{
    public function testRenders403AndDoesNotCallNextWhenNotAuthorized()
    {
        /** @var AuthorizationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authorization */
        $authorization = $this->createMock(AuthorizationServiceInterface::class);
        $authorization->expects(self::once())
            ->method('hasRole')
            ->with(self::isInstanceOf(AttendeeRole::class))
            ->willReturn(false);

        $content = uniqid('content', true);
        /** @var TemplateRendererInterface|\PHPUnit_Framework_MockObject_MockObject $renderer */
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())
            ->method('render')
            ->with('error/403')
            ->willReturn($content);

        $response = (new HasAttendeeRoleMiddleware($authorization, $renderer))->__invoke(
            new ServerRequest(),
            new Response(),
            function () {
                $this->fail('Next middleware should NOT have been called');
            }
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($content, $response->getBody()->__toString());
        self::assertSame(403, $response->getStatusCode());
    }

    public function testCallsNextWhenAuthorized()
    {
        /** @var AuthorizationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authorization */
        $authorization = $this->createMock(AuthorizationServiceInterface::class);
        $authorization->expects(self::once())
            ->method('hasRole')
            ->with(self::isInstanceOf(AttendeeRole::class))
            ->willReturn(true);

        /** @var TemplateRendererInterface|\PHPUnit_Framework_MockObject_MockObject $renderer */
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::never())->method('render');

        $nextCalled = false;
        $expectedResponse = new Response();
        self::assertSame($expectedResponse, (new HasAttendeeRoleMiddleware($authorization, $renderer))->__invoke(
            new ServerRequest(),
            new Response(),
            function () use (&$nextCalled, $expectedResponse) {
                $nextCalled = true;
                return $expectedResponse;
            }
        ));
    }
}

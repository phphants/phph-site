<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\TeamAction;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\TeamAction
 */
final class TeamActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersView()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('app::team')->willReturn('content...');

        $response = (new TeamAction($renderer))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

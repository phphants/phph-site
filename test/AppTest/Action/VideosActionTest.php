<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\VideosAction;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\VideosAction
 */
final class VideosActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersView()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('app::videos')->willReturn('content...');

        $response = (new VideosAction($renderer))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

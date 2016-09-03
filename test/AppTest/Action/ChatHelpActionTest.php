<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\ChatHelpAction;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\ChatHelpAction
 */
final class ChatHelpActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersView()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('app::chat-help')->willReturn('content...');

        $response = (new ChatHelpAction($renderer))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

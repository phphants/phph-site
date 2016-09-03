<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\ContactAction;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\ContactAction
 */
final class ContactActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersView()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('app::contact')->willReturn('content...');

        $response = (new ContactAction($renderer))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\CodeOfConductAction;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\CodeOfConductAction
 */
final class CodeOfConductActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersView()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('app::code-of-conduct')->willReturn('content...');

        $response = (new CodeOfConductAction($renderer))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

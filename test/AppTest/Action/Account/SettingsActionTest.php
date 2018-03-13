<?php
declare(strict_types=1);

namespace AppTest\Action\Account;

use App\Action\Account\SettingsAction;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\SettingsAction
 */
final class SettingsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersView(): void
    {
        $expectedContent = uniqid('content', true);
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::settings')->willReturn($expectedContent);

        $response = (new SettingsAction($renderer))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($expectedContent, (string)$response->getBody());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Speaker;

use App\Action\Account\Speaker\ListSpeakersAction;
use App\Entity\Speaker;
use App\Service\Speaker\GetAllSpeakersInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\Speaker\ListSpeakersAction
 */
final class ListSpeakersActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodDisplaysSpeakers()
    {
        $speakers = [
            $this->createMock(Speaker::class),
            $this->createMock(Speaker::class),
        ];

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::speaker/list', [
            'speakers' => $speakers,
        ])->willReturn('content...');

        $getAllSpeakers = $this->createMock(GetAllSpeakersInterface::class);
        $getAllSpeakers->expects(self::once())->method('__invoke')->with()->willReturn($speakers);

        $response = (new ListSpeakersAction($renderer, $getAllSpeakers))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

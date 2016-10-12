<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\VideosAction;
use App\Entity\Talk;
use App\Service\Talk\FindTalksWithVideoInterface;
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
        $videos = [
            $this->createMock(Talk::class),
            $this->createMock(Talk::class),
        ];

        $talksWithVideo = $this->createMock(FindTalksWithVideoInterface::class);
        $talksWithVideo->expects(self::once())->method('__invoke')->willReturn($videos);

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('app::videos', [
            'talksWithVideo' => $videos,
        ])->willReturn('content...');

        $response = (new VideosAction($renderer, $talksWithVideo))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

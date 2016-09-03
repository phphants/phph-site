<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\MeetupsAction;
use App\Service\MeetupsServiceInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\MeetupsAction
 */
final class MeetupsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersViewAndRetrievesPastAndFutureMeetups()
    {
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('app::meetups')->willReturn('content...');

        $meetupsService = $this->createMock(MeetupsServiceInterface::class);
        $meetupsService->expects(self::once())->method('getFutureMeetups')->willReturn([]);
        $meetupsService->expects(self::once())->method('getPastMeetups')->willReturn([]);

        $response = (new MeetupsAction($meetupsService, $renderer))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

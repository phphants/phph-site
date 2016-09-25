<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Meetup;

use App\Action\Account\Meetup\ListMeetupsAction;
use App\Entity\Meetup;
use App\Service\Meetup\GetAllMeetupsInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\Meetup\ListMeetupsAction
 */
final class ListMeetupsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodDisplaysMeetup()
    {
        $meetups = [
            $this->createMock(Meetup::class),
            $this->createMock(Meetup::class),
        ];

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::meetup/list', [
            'meetups' => $meetups,
        ])->willReturn('content...');

        $getAllMeetups = $this->createMock(GetAllMeetupsInterface::class);
        $getAllMeetups->expects(self::once())->method('__invoke')->with()->willReturn($meetups);

        $response = (new ListMeetupsAction($renderer, $getAllMeetups))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

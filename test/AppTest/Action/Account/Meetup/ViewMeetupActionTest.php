<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Meetup;

use App\Action\Account\Meetup\ViewMeetupAction;
use App\Entity\Meetup;
use App\Service\Meetup\FindMeetupByUuidInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\Meetup\ViewMeetupAction
 */
final class ViewMeetupActionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetMethodDisplaysMeetup()
    {
        $meetup = $this->createMock(Meetup::class);
        $meetup->expects(self::any())->method('getId')->willReturn(Uuid::uuid4());

        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::meetup/view', [
            'meetup' => $meetup,
        ])->willReturn('content...');

        $findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $findMeetup->expects(self::once())->method('__invoke')->with($meetup->getId())->willReturn($meetup);

        $response = (new ViewMeetupAction($renderer, $findMeetup))->__invoke(
            (new ServerRequest(['/']))
                ->withAttribute('uuid', $meetup->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame('content...', (string)$response->getBody());
    }
}

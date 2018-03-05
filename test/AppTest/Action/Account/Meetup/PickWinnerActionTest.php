<?php
declare(strict_types=1);

namespace AppTest\Action\Account\Meetup;

use App\Action\Account\Meetup\PickWinnerAction;
use App\Entity\Location;
use App\Entity\Meetup;
use App\Entity\User;
use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\User\PhpPasswordHash;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @covers \App\Action\Account\Meetup\PickWinnerAction
 */
final class PickWinnerActionTest extends TestCase
{
    public function testWinnerIsPickedAndTemplateIsRendered(): void
    {
        $from = new DateTimeImmutable('2016-06-01 19:00:00');
        $to = new DateTimeImmutable('2016-06-01 23:00:00');
        $location = Location::fromNameAddressAndUrl('Location 1', 'Address 1', 'http://test-uri-1');

        $meetup = Meetup::fromStandardMeetup($from, $to, $location);
        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), 'password');

        $meetup->attend($user);
        $meetup->checkInAttendee($user, new DateTimeImmutable());

        $expectedContent = uniqid('content', true);
        $renderer = $this->createMock(TemplateRendererInterface::class);
        $renderer->expects(self::once())->method('render')->with('account::meetup/pick-a-winner', [
            'meetup' => $meetup,
            'winner' => $user,
        ])->willReturn($expectedContent);

        $findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $findMeetup->expects(self::once())->method('__invoke')->with($meetup->getId())->willReturn($meetup);

        $response = (new PickWinnerAction($renderer, $findMeetup))->__invoke(
            (new ServerRequest(['/']))
                ->withAttribute('meetup', $meetup->getId()),
            new Response()
        );

        self::assertInstanceOf(Response\HtmlResponse::class, $response);
        self::assertSame($expectedContent, (string)$response->getBody());
    }
}

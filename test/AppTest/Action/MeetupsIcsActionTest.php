<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\MeetupsIcsAction;
use App\Entity\Location;
use App\Entity\Meetup;
use App\Service\Meetup\MeetupsServiceInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * @covers \App\Action\MeetupsIcsAction
 */
final class MeetupsIcsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersViewAndRetrievesFutureMeetups()
    {
        $meetupsService = $this->createMock(MeetupsServiceInterface::class);
        $meetupsService->expects(self::once())->method('findMeetupsAfter')->willReturn([
            Meetup::fromStandardMeetup(
                new \DateTimeImmutable(),
                new \DateTimeImmutable(),
                Location::fromNameAddressAndUrl(
                    'Foo',
                    'Foo Adddress',
                    'http://test-uri/'
                )
            )
        ]);
        $meetupsService->expects(self::never())->method('findMeetupsBefore');

        $response = (new MeetupsIcsAction($meetupsService))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\TextResponse::class, $response);
        self::assertStringStartsWith('BEGIN:VCALENDAR', (string)$response->getBody());
    }
}

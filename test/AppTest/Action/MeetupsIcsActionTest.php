<?php
declare(strict_types = 1);

namespace AppTest\Action;

use App\Action\MeetupsIcsAction;
use App\Entity\Meetup;
use App\Service\MeetupsServiceInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;

/**
 * @covers \App\Action\MeetupsIcsAction
 */
final class MeetupsIcsActionTest extends \PHPUnit_Framework_TestCase
{
    public function testActionRendersViewAndRetrievesFutureMeetups()
    {
        $meetup = new Meetup();
        $meetup->setFromDate(new \DateTimeImmutable());
        $meetup->setToDate(new \DateTimeImmutable());

        $meetupsService = $this->createMock(MeetupsServiceInterface::class);
        $meetupsService->expects(self::once())->method('getFutureMeetups')->willReturn([$meetup]);
        $meetupsService->expects(self::never())->method('getPastMeetups');

        $response = (new MeetupsIcsAction($meetupsService))->__invoke(
            new ServerRequest(['/']),
            new Response()
        );

        self::assertInstanceOf(Response\TextResponse::class, $response);
        self::assertStringStartsWith('BEGIN:VCALENDAR', (string)$response->getBody());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Action\Account\Meetup;

use App\Action\Account\Meetup\CancelCheckInAction;
use App\Entity\Location;
use App\Entity\Meetup;
use App\Entity\User;
use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\User\FindUserByUuidInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequest;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @covers \App\Action\Account\Meetup\CancelCheckInAction
 */
final class CancelCheckInActionTest extends \PHPUnit_Framework_TestCase
{
    public function testCheckInForUser()
    {
        $meetup = Meetup::fromStandardMeetup(
            new \DateTimeImmutable('2016-06-01 19:00:00'),
            new \DateTimeImmutable('2016-06-01 23:00:00'),
            Location::fromNameAddressAndUrl('Location 1', 'Address 1', 'http://test-uri-1')
        );

        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), 'correct horse battery staple');
        $meetup->attend($user);
        $meetup->checkInAttendee($user, new \DateTimeImmutable());

        /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');

        /** @var FindMeetupByUuidInterface|\PHPUnit_Framework_MockObject_MockObject $findMeetup */
        $findMeetup = $this->createMock(FindMeetupByUuidInterface::class);
        $findMeetup->expects(self::once())
            ->method('__invoke')
            ->with($meetup->getId())
            ->willReturn($meetup);

        /** @var FindUserByUuidInterface|\PHPUnit_Framework_MockObject_MockObject $findUser */
        $findUser = $this->createMock(FindUserByUuidInterface::class);
        $findUser->expects(self::once())
            ->method('__invoke')
            ->with(Uuid::fromString($user->id()))
            ->willReturn($user);

        $expectedUrl = uniqid('/url', true);
        /** @var UrlHelper|\PHPUnit_Framework_MockObject_MockObject $urlHelper */
        $urlHelper = $this->createMock(UrlHelper::class);
        $urlHelper->expects(self::once())->method('generate')->willReturn($expectedUrl);

        $action = new CancelCheckInAction(
            $entityManager,
            $findMeetup,
            $findUser,
            $urlHelper
        );

        $response = $action->__invoke(
            (new ServerRequest())
                ->withMethod('POST')
                ->withAttribute('meetup', $meetup->getId())
                ->withAttribute('user', $user->id()),
            new Response()
        );

        self::assertInstanceOf(Response\RedirectResponse::class, $response);
        self::assertSame($expectedUrl, $response->getHeaderLine('Location'));

        self::assertSame(1, $meetup->attendance());
        foreach ($meetup->attendees() as $meetupAttendee) {
            self::assertFalse($meetupAttendee->checkedIn());
        }
    }
}

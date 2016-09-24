<?php
declare(strict_types = 1);

namespace AppTest\Service\Meetup;

use App\Entity\Location;
use App\Entity\Meetup;
use App\Service\Meetup\DoctrineFindMeetupByUuid;
use App\Service\Meetup\Exception\MeetupNotFound;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Meetup\DoctrineFindMeetupByUuid
 */
class DoctrineFindMeetupByUuidTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionThrownWhenMeetupNotFound()
    {
        $uuid = Uuid::uuid4();

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => (string)$uuid])
            ->willReturn(null);

        $this->expectException(MeetupNotFound::class);
        (new DoctrineFindMeetupByUuid($objectRepository))->__invoke($uuid);
    }

    public function testLocationIsReturned()
    {
        $meetup = Meetup::fromStandardMeetup(
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            Location::fromNameAddressAndUrl('', '', '')
        );

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => $meetup->getId()])
            ->willReturn($meetup);

        self::assertSame(
            $meetup,
            (new DoctrineFindMeetupByUuid($objectRepository))->__invoke(
                Uuid::fromString($meetup->getId())
            )
        );
    }
}

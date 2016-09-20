<?php
declare(strict_types = 1);

namespace AppTest\Service\Meetup;

use App\Entity\Location;
use App\Service\Location\DoctrineFindLocationByUuid;
use App\Service\Location\Exception\LocationNotFound;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Location\DoctrineFindLocationByUuid
 */
class DoctrineFindLocationByUuidTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionThrownWhenLocationNotFound()
    {
        $uuid = Uuid::uuid4();

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => (string)$uuid])
            ->willReturn(null);

        $this->expectException(LocationNotFound::class);
        (new DoctrineFindLocationByUuid($objectRepository))->__invoke($uuid);
    }

    public function testLocationIsReturned()
    {
        $location = Location::fromNameAddressAndUrl('foo', 'bar', 'baz');

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => $location->getId()])
            ->willReturn($location);

        self::assertSame(
            $location,
            (new DoctrineFindLocationByUuid($objectRepository))->__invoke(
                Uuid::fromString($location->getId())
            )
        );
    }
}

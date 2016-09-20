<?php
declare(strict_types = 1);

namespace AppTest\Service\Meetup;

use App\Entity\Location;
use App\Service\Location\DoctrineGetAllLocations;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @covers \App\Service\Location\DoctrineGetAllLocations
 */
class DoctrineGetAllLocationsTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeCallsFindAllOnObjectRepository()
    {
        $locations = [
            Location::fromNameAddressAndUrl('foo', 'foo', 'foo'),
            Location::fromNameAddressAndUrl('bar', 'bar', 'bar'),
        ];

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())->method('findAll')->with()->willReturn($locations);

        self::assertSame($locations, (new DoctrineGetAllLocations($objectRepository))->__invoke());
    }
}

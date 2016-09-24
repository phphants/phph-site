<?php
declare(strict_types = 1);

namespace AppTest\Service\Location;

use App\Entity\Meetup;
use App\Service\Meetup\DoctrineGetAllMeetups;
use Doctrine\Common\Persistence\ObjectRepository;

/**
 * @covers \App\Service\Meetup\DoctrineGetAllMeetups
 */
class DoctrineGetAllMeetupsTest extends \PHPUnit_Framework_TestCase
{
    public function testInvokeCallsFindAllOnObjectRepository()
    {
        $meetups = [
            $this->createMock(Meetup::class),
            $this->createMock(Meetup::class),
        ];

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())->method('findAll')->with()->willReturn($meetups);

        self::assertSame($meetups, (new DoctrineGetAllMeetups($objectRepository))->__invoke());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Service\Talk;

use App\Entity\Speaker;
use App\Service\Speaker\DoctrineFindSpeakerByUuid;
use App\Service\Speaker\Exception\SpeakerNotFound;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Speaker\DoctrineFindSpeakerByUuid
 */
class DoctrineFindSpeakerByUuidTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionThrownWhenMeetupNotFound()
    {
        $uuid = Uuid::uuid4();

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => (string)$uuid])
            ->willReturn(null);

        $this->expectException(SpeakerNotFound::class);
        (new DoctrineFindSpeakerByUuid($objectRepository))->__invoke($uuid);
    }

    public function testLocationIsReturned()
    {
        $speaker = Speaker::fromNameAndTwitter(
            'My Full Name',
            'MyTwitterHandle'
        );

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => $speaker->getId()])
            ->willReturn($speaker);

        self::assertSame(
            $speaker,
            (new DoctrineFindSpeakerByUuid($objectRepository))->__invoke(
                Uuid::fromString($speaker->getId())
            )
        );
    }
}

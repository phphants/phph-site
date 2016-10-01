<?php
declare(strict_types = 1);

namespace AppTest\Service\Talk;

use App\Entity\Talk;
use App\Service\Talk\DoctrineFindTalkByUuid;
use App\Service\Talk\Exception\TalkNotFound;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Talk\DoctrineFindTalkByUuid
 */
class DoctrineFindTalkByUuidTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionThrownWhenMeetupNotFound()
    {
        $uuid = Uuid::uuid4();

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => (string)$uuid])
            ->willReturn(null);

        $this->expectException(TalkNotFound::class);
        (new DoctrineFindTalkByUuid($objectRepository))->__invoke($uuid);
    }

    public function testLocationIsReturned()
    {
        $talk = $this->createMock(Talk::class);
        $uuid = (string)Uuid::uuid4();

        $objectRepository = $this->createMock(ObjectRepository::class);
        $objectRepository->expects(self::once())
            ->method('findOneBy')
            ->with(['id' => $uuid])
            ->willReturn($talk);

        self::assertSame(
            $talk,
            (new DoctrineFindTalkByUuid($objectRepository))->__invoke(
                Uuid::fromString($uuid)
            )
        );
    }
}

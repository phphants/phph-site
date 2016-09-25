<?php
declare(strict_types = 1);

namespace AppTest\Service\Meetup\Exception;

use App\Service\Meetup\Exception\MeetupNotFound;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Meetup\Exception\MeetupNotFound
 */
class MeetupNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUsername()
    {
        $uuid = Uuid::fromString('204a5eee-a406-475d-95c2-9cb28f2b086d');

        $exception = MeetupNotFound::fromUuid($uuid);

        self::assertInstanceOf(MeetupNotFound::class, $exception);
        self::assertSame('Meetup with uuid 204a5eee-a406-475d-95c2-9cb28f2b086d not found', $exception->getMessage());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Service\Talk\Exception;

use App\Service\Talk\Exception\TalkNotFound;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Talk\Exception\TalkNotFound
 */
class TalkNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUuid()
    {
        $uuid = Uuid::fromString('204a5eee-a406-475d-95c2-9cb28f2b086d');

        $exception = TalkNotFound::fromUuid($uuid);

        self::assertInstanceOf(TalkNotFound::class, $exception);
        self::assertSame('Talk with uuid 204a5eee-a406-475d-95c2-9cb28f2b086d not found', $exception->getMessage());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Service\Speaker\Exception;

use App\Service\Speaker\Exception\SpeakerNotFound;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Speaker\Exception\SpeakerNotFound
 */
class SpeakerNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUuid()
    {
        $uuid = Uuid::fromString('204a5eee-a406-475d-95c2-9cb28f2b086d');

        $exception = SpeakerNotFound::fromUuid($uuid);

        self::assertInstanceOf(SpeakerNotFound::class, $exception);
        self::assertSame('Speaker with uuid 204a5eee-a406-475d-95c2-9cb28f2b086d not found', $exception->getMessage());
    }
}

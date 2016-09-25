<?php
declare(strict_types = 1);

namespace AppTest\Service\Location\Exception;

use App\Service\Location\Exception\LocationNotFound;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Service\Location\Exception\LocationNotFound
 */
class LocationNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUsername()
    {
        $uuid = Uuid::fromString('204a5eee-a406-475d-95c2-9cb28f2b086d');

        $exception = LocationNotFound::fromUuid($uuid);

        self::assertInstanceOf(LocationNotFound::class, $exception);
        self::assertSame('Location with uuid 204a5eee-a406-475d-95c2-9cb28f2b086d not found', $exception->getMessage());
    }
}

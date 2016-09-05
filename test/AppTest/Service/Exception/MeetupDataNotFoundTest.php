<?php
declare(strict_types = 1);

namespace AppTest\Service\Exception;

use App\Service\Exception\MeetupDataNotFound;

/**
 * @covers \App\Service\Exception\MeetupDataNotFound
 */
class MeetupDataNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testFromFilenameAndData()
    {
        $exception = MeetupDataNotFound::fromFilename('/foo/bar');

        self::assertInstanceOf(MeetupDataNotFound::class, $exception);
        self::assertSame('Could not find meetup data file: /foo/bar', $exception->getMessage());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Service\Exception;

use App\Service\Exception\InvalidMeetupData;

/**
 * @covers \App\Service\Exception\InvalidMeetupData
 */
class InvalidMeetupDataTest extends \PHPUnit_Framework_TestCase
{
    public function testFromFilenameAndData()
    {
        $exception = InvalidMeetupData::fromFilenameAndData('/foo/bar', 123);

        self::assertInstanceOf(InvalidMeetupData::class, $exception);
        self::assertSame(
            'Meetup file /foo/bar did not return a valid Meetup entity (was integer)',
            $exception->getMessage()
        );
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\EventbriteData;
use App\Entity\Meetup;

/**
 * @covers \App\Entity\EventbriteData
 */
class EventbriteDataTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUrlAndEventbriteId()
    {
        $data = EventbriteData::fromUrlAndEventbriteId($this->createMock(Meetup::class), 'http://test-uri', '12345');

        self::assertSame('12345', $data->getEventbriteId());
        self::assertSame('http://test-uri', $data->getUrl());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\EventbriteData;
use App\Entity\Location;
use App\Entity\Meetup;
use App\Entity\Speaker;
use App\Entity\Talk;

/**
 * @covers \App\Entity\Meetup
 */
class MeetupTest extends \PHPUnit_Framework_TestCase
{
    public function testFromStandardMeetup()
    {
        $from = new \DateTimeImmutable('2016-12-31 19:00:00');
        $to = new \DateTimeImmutable('2016-12-31 23:00:00');
        $location = Location::fromNameAddressAndUrl('Location', 'Address', 'http://test-uri');
        $talks = [
            $talk = $this->createMock(Talk::class),
        ];
        $topic = 'MyTopic';

        $meetup = Meetup::fromStandardMeetup($from, $to, $location, $talks, $topic);

        $eventbriteData = $this->createMock(EventbriteData::class);
        $eventbriteDataProperty = new \ReflectionProperty($meetup, 'eventbriteData');
        $eventbriteDataProperty->setAccessible(true);
        $eventbriteDataProperty->setValue($meetup, $eventbriteData);

        self::assertSame('2016-12-31 19:00:00', $meetup->getFromDate()->format('Y-m-d H:i:s'));
        self::assertSame('2016-12-31 23:00:00', $meetup->getToDate()->format('Y-m-d H:i:s'));
        self::assertNotSame($from, $meetup->getFromDate());
        self::assertNotSame($to, $meetup->getFromDate());
        self::assertSame([$talk], $meetup->getTalks()->toArray());
        self::assertSame($location, $meetup->getLocation());
        self::assertSame($topic, $meetup->getTopic());
        self::assertSame($eventbriteData, $meetup->getEventbriteData());
    }

    public function testExceptionThrownCreatingEntityWithInvalidTalk()
    {
        $from = new \DateTimeImmutable('2016-12-31 19:00:00');
        $to = new \DateTimeImmutable('2016-12-31 23:00:00');
        $location = Location::fromNameAddressAndUrl('Location', 'Address', 'http://test-uri');
        $talks = [
            new \stdClass(),
        ];
        $topic = 'MyTopic';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Item with key 0 in talks was not a Talk');
        Meetup::fromStandardMeetup($from, $to, $location, $talks, $topic);
    }

    public function testGetAbbreviatedTalksOnlyFetchesTalksWithSpeakers()
    {
        $from = new \DateTimeImmutable('2016-12-31 19:00:00');
        $to = new \DateTimeImmutable('2016-12-31 23:00:00');
        $location = Location::fromNameAddressAndUrl('Location', 'Address', 'http://test-uri');
        $talks = [
            $talkWithSpeaker = $this->createMock(Talk::class),
            $talkWithoutSpeaker = $this->createMock(Talk::class),
        ];
        $topic = 'MyTopic';

        $talkWithSpeaker->expects(self::once())->method('getSpeaker')->willReturn(Speaker::fromNameAndTwitter(
            'Happy Harry',
            'HappyHarry'
        ));

        $talkWithoutSpeaker->expects(self::once())->method('getSpeaker')->willReturn(null);

        $meetup = Meetup::fromStandardMeetup($from, $to, $location, $talks, $topic);

        $abbreviatedTalks = $meetup->getAbbreviatedTalks();

        self::assertCount(1, $abbreviatedTalks);
        self::assertSame($talkWithSpeaker, $abbreviatedTalks->first());
    }
}

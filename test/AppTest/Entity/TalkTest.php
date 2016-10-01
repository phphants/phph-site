<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\Meetup;
use App\Entity\Speaker;
use App\Entity\Talk;
use Ramsey\Uuid\Uuid;

/**
 * @covers \App\Entity\Talk
 */
class TalkTest extends \PHPUnit_Framework_TestCase
{
    public function testFromTitle()
    {
        $meetup = $this->createMock(Meetup::class);
        $time = new \DateTimeImmutable('2016-12-31 23:59:59');

        $talk = Talk::fromTitle($meetup, $time, 'Some thing');

        self::assertTrue(Uuid::isValid($talk->getId()));
        self::assertSame($meetup, $talk->getMeetup());
        self::assertSame('2016-12-31 23:59:59', $talk->getTime()->format('Y-m-d H:i:s'));
        self::assertSame('Some thing', $talk->getTitle());
        self::assertNull($talk->getSpeaker());
        self::assertNull($talk->getAbstract());
    }

    public function testFromStandardTalk()
    {
        $meetup = $this->createMock(Meetup::class);
        $time = new \DateTimeImmutable('2016-12-31 23:59:59');
        $speaker = Speaker::fromNameAndTwitter('Foobar');

        $talk = Talk::fromStandardTalk($meetup, $time, $speaker, 'Talk title', 'About the talk some text');

        self::assertTrue(Uuid::isValid($talk->getId()));
        self::assertSame($meetup, $talk->getMeetup());
        self::assertSame('2016-12-31 23:59:59', $talk->getTime()->format('Y-m-d H:i:s'));
        self::assertSame('Talk title', $talk->getTitle());
        self::assertSame($speaker, $talk->getSpeaker());
        self::assertSame('About the talk some text', $talk->getAbstract());
    }

    public function testUpdateFromData()
    {
        $meetup = $this->createMock(Meetup::class);
        $time = new \DateTimeImmutable('2016-12-31 23:59:59');
        $speaker = Speaker::fromNameAndTwitter('Foobar');

        $talk = Talk::fromStandardTalk($meetup, $time, $speaker, 'Talk title', 'About the talk some text');

        $talk->updateFromData(
            new \DateTimeImmutable('2017-11-30 23:59:59'),
            'Updated talk title',
            '',
            null
        );

        self::assertSame('2017-11-30 23:59:59', $talk->getTime()->format('Y-m-d H:i:s'));
        self::assertSame('Updated talk title', $talk->getTitle());
        self::assertNull($talk->getSpeaker());
        self::assertNull($talk->getAbstract());
    }
}

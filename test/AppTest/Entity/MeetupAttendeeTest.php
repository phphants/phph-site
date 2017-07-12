<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\Location;
use App\Entity\Meetup;
use App\Entity\MeetupAttendee;
use App\Entity\User;
use App\Service\User\PhpPasswordHash;

/**
 * @covers \App\Entity\MeetupAttendee
 */
final class MeetupAttendeeTest extends \PHPUnit_Framework_TestCase
{
    public function testMeetupAttendeeIsInitiallyNotCheckedIn()
    {
        $from = new \DateTimeImmutable('2016-12-31 19:00:00');
        $to = new \DateTimeImmutable('2016-12-31 23:00:00');
        $location = Location::fromNameAddressAndUrl('Location', 'Address', 'http://test-uri');
        $topic = 'MyTopic';

        $meetup = Meetup::fromStandardMeetup($from, $to, $location, $topic);
        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), '');

        $attendee = new MeetupAttendee($meetup, $user);

        self::assertSame($meetup, $attendee->meetup());
        self::assertSame($user, $attendee->attendee());
        self::assertFalse($attendee->checkedIn());
    }

    public function testMeetupAttendeeCanCheckInAndCancelCheckIn()
    {
        $from = new \DateTimeImmutable('2016-12-31 19:00:00');
        $to = new \DateTimeImmutable('2016-12-31 23:00:00');
        $location = Location::fromNameAddressAndUrl('Location', 'Address', 'http://test-uri');
        $topic = 'MyTopic';

        $meetup = Meetup::fromStandardMeetup($from, $to, $location, $topic);
        $user = User::new('foo@bar.com', 'My Name', new PhpPasswordHash(), '');

        $attendee = new MeetupAttendee($meetup, $user);

        self::assertFalse($attendee->checkedIn());
        $attendee->checkIn(new \DateTimeImmutable());
        self::assertTrue($attendee->checkedIn());
        $attendee->cancelCheckIn();
        self::assertFalse($attendee->checkedIn());
    }
}

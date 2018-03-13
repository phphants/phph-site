<?php
declare(strict_types=1);

namespace App\Entity;

use Assert\Assertion;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="meetup")
 */
/*final */class Meetup
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     * @var string
     */
    private $id;

    /**
     * @ORM\Column(name="from_date", type="datetime", nullable=false)
     * @var DateTimeImmutable
     */
    private $fromDate;

    /**
     * @ORM\Column(name="to_date", type="datetime", nullable=false)
     * @var DateTimeImmutable
     */
    private $toDate;

    /**
     * @ORM\OneToOne(targetEntity=EventbriteData::class, mappedBy="meetup")
     * @var EventbriteData
     */
    private $eventbriteData;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class)
     * @ORM\JoinColumn(name="location_id", referencedColumnName="id", nullable=false)
     * @var Location
     */
    private $location;

    /**
     * @ORM\Column(name="topic", type="string", length=1024, nullable=true)
     * @var string
     */
    private $topic;

    /**
     * @ORM\OneToMany(targetEntity=Talk::class, mappedBy="meetup")
     * @ORM\OrderBy({"time" = "ASC"})
     * @var ArrayCollection|Talk[]
     */
    private $talks;

    /**
     * @ORM\OneToMany(
     *     targetEntity=MeetupAttendee::class,
     *     mappedBy="meetup",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     * @var ArrayCollection|MeetupAttendee[]
     */
    private $meetupAttendees;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->talks = new ArrayCollection();
        $this->meetupAttendees = new ArrayCollection();
    }

    /**
     * @param DateTimeImmutable $from
     * @param DateTimeImmutable $to
     * @param Location $location
     * @param string $topic
     * @return Meetup
     * @throws \InvalidArgumentException
     */
    public static function fromStandardMeetup(
        DateTimeImmutable $from,
        DateTimeImmutable $to,
        Location $location,
        string $topic = null
    ) : self {
        Assertion::greaterThan($to, $from, 'To date should be after From date');

        $meetup = new self();
        $meetup->fromDate = new \DateTimeImmutable($from->format('Y-m-d H:i:s'));
        $meetup->toDate = new \DateTimeImmutable($to->format('Y-m-d H:i:s'));
        $meetup->location = $location;
        $meetup->topic = $topic;

        return $meetup;
    }

    /**
     * @param DateTimeImmutable $from
     * @param DateTimeImmutable $to
     * @param Location $location
     * @return void
     */
    public function updateFromData(
        DateTimeImmutable $from,
        DateTimeImmutable $to,
        Location $location
    ) {
        Assertion::greaterThan($to, $from, 'To date should be after From date');

        $this->fromDate = new \DateTimeImmutable($from->format('Y-m-d H:i:s'));
        $this->toDate = new \DateTimeImmutable($to->format('Y-m-d H:i:s'));
        $this->location = $location;
    }

    public function getId() : string
    {
        return (string)$this->id;
    }

    public function getFromDate() : \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->fromDate->format('Y-m-d H:i:s'));
    }

    public function getToDate() : \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->toDate->format('Y-m-d H:i:s'));
    }

    /**
     * @return Talk[]|Collection
     */
    public function getTalks() : Collection
    {
        return $this->talks;
    }

    public function getAbbreviatedTalks() : Collection
    {
        return $this->talks->filter(function (Talk $talk) {
            return null !== $talk->getSpeaker();
        });
    }

    /**
     * @return EventbriteData|null
     */
    public function getEventbriteData()
    {
        return $this->eventbriteData;
    }

    public function getLocation() : Location
    {
        return $this->location;
    }

    /**
     * @return string|null
     */
    public function getTopic()
    {
        return $this->topic;
    }

    public function isBefore(\DateTimeImmutable $date) : bool
    {
        return ($this->toDate < $date);
    }

    public function attend(User $user) : void
    {
        foreach ($this->meetupAttendees as $meetupAttendee) {
            /** @var MeetupAttendee $meetupAttendee */
            if ($meetupAttendee->attendee()->id() === $user->id()) {
                return;
            }
        }
        $attendance = new MeetupAttendee($this, $user);
        $this->meetupAttendees->add($attendance);
        $user->meetupsAttended()->add($attendance);
    }

    public function cancelAttendance(User $user) : void
    {
        foreach ($this->meetupAttendees as $meetupAttendee) {
            /** @var MeetupAttendee $meetupAttendee */
            if ($meetupAttendee->attendee()->id() === $user->id()) {
                $this->meetupAttendees->removeElement($meetupAttendee);
                $user->meetupsAttended()->removeElement($meetupAttendee);
            }
        }
    }

    /**
     * @return MeetupAttendee[]
     */
    public function attendees() : array
    {
        return $this->meetupAttendees->toArray();
    }

    /**
     * @return MeetupAttendee[]
     */
    private function attendeesEligibleForPrizeDraws() : array
    {
        return $this->meetupAttendees->filter(function (MeetupAttendee $attendee) {
            return $attendee->checkedIn() && $attendee->attendee()->eligibleForPrizeDraws();
        })->toArray();
    }

    /**
     * Pick a winner at random (uses `random_int`) from the eligible and checked in attendees
     *
     * @return User
     * @throws \RuntimeException
     */
    public function pickPrizeDrawWinner() : User
    {
        /** @var MeetupAttendee[] $eligibleAttendees */
        $eligibleAttendees = array_values($this->attendeesEligibleForPrizeDraws());
        if (0 === \count($eligibleAttendees)) {
            throw new \RuntimeException('There are no eligible attendees');
        }
        return $eligibleAttendees[random_int(0, \count($eligibleAttendees) - 1)]->attendee();
    }

    public function attendance() : int
    {
        return $this->meetupAttendees->count();
    }

    public function checkInAttendee(User $user, \DateTimeImmutable $atTime) : void
    {
        foreach ($this->meetupAttendees as $meetupAttendee) {
            /** @var MeetupAttendee $meetupAttendee */
            if ($meetupAttendee->attendee()->id() === $user->id()) {
                $meetupAttendee->checkIn($atTime);
                return;
            }
        }

        throw Exception\UserNotAttending::fromMeetupAndUser($this, $user);
    }

    public function cancelCheckIn(User $user) : void
    {
        foreach ($this->meetupAttendees as $meetupAttendee) {
            /** @var MeetupAttendee $meetupAttendee */
            if ($meetupAttendee->attendee()->id() === $user->id()) {
                $meetupAttendee->cancelCheckIn();
                return;
            }
        }

        throw Exception\UserNotAttending::fromMeetupAndUser($this, $user);
    }
}

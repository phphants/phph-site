<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="meetup_attendees", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="meetup_user", columns={"meetup_id", "user_id"})
 * })
 */
/*final */class MeetupAttendee
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     * @var string
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Meetup::class, inversedBy="meetupAttendees")
     * @ORM\JoinColumn(name="meetup_id", referencedColumnName="id", nullable=false)
     * @var User
     */
    private $meetup;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="meetupsAttended")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
     * @var User
     */
    private $user;

    public function __construct(Meetup $meetup, User $attendee)
    {
        $this->id = Uuid::uuid4();
        $this->meetup = $meetup;
        $this->user = $attendee;
    }

    public function meetup() : Meetup
    {
        return $this->meetup;
    }

    public function attendee() : User
    {
        return $this->user;
    }
}

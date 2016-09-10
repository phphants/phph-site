<?php
declare(strict_types=1);

namespace App\Entity;

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

    private function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->talks = new ArrayCollection();
    }

    /**
     * @param DateTimeImmutable $from
     * @param DateTimeImmutable $to
     * @param Location $location
     * @param Talk[] $talks
     * @param string $topic
     * @return Meetup
     * @throws \InvalidArgumentException
     */
    public static function fromStandardMeetup(
        DateTimeImmutable $from,
        DateTimeImmutable $to,
        Location $location,
        array $talks,
        string $topic = null
    ) : self {
        $meetup = new self();
        $meetup->fromDate = $from;
        $meetup->toDate = $to;
        $meetup->location = $location;
        $meetup->topic = $topic;

        foreach ($talks as $k => $talk) {
            if (!$talk instanceof Talk) {
                throw new \InvalidArgumentException(sprintf('Item with key %s in talks was not a Talk', $k));
            }
        }
        return $meetup;
    }

    public function getFromDate() : \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->fromDate->format('Y-m-d'));
    }

    public function getToDate() : \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->toDate->format('Y-m-d'));
    }

    /**
     * @return Talk[]|Collection
     */
    public function getTalks() : Collection
    {
        return $this->talks;
    }

    public function getEventbriteData() : EventbriteData
    {
        return $this->eventbriteData;
    }

    public function getLocation() : Location
    {
        return $this->location;
    }

    public function getTopic() : string
    {
        return $this->topic;
    }
}

<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="talk")
 */
/*final */class Talk
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Meetup::class, inversedBy="talks")
     * @ORM\JoinColumn(name="meetup_id", referencedColumnName="id", nullable=false)
     * @var Meetup
     */
    private $meetup;

    /**
     * @ORM\Column(name="time", type="datetime", nullable=false)
     * @var DateTimeImmutable
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity=Speaker::class)
     * @ORM\JoinColumn(name="speaker_id", referencedColumnName="id", nullable=true)
     * @var Speaker
     */
    private $speaker;

    /**
     * @ORM\Column(name="title", type="string", length=1024, nullable=false)
     * @var string
     */
    private $title;

    /**
     * @ORM\Column(name="abstract", type="string", nullable=true)
     * @var string
     */
    private $abstract;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function fromTitle(Meetup $meetup, DateTimeImmutable $time, string $title) : self
    {
        $talk = new self();
        $talk->meetup = $meetup;
        $talk->time = $time;
        $talk->title = $title;
        return $talk;
    }

    public static function fromStandardTalk(
        Meetup $meetup,
        DateTimeImmutable $time,
        Speaker $speaker,
        string $title,
        string $abstract
    ) : self
    {
        $talk = new self();
        $talk->meetup = $meetup;
        $talk->time = $time;
        $talk->speaker = $speaker;
        $talk->title = $title;
        $talk->abstract = $abstract;
        return $talk;
    }

    public function getSpeaker() : Speaker
    {
        return $this->speaker;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function getAbstract() : string
    {
        return $this->abstract;
    }
}

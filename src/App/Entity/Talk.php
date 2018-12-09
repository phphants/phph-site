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
     * @ORM\Column(name="abstract", type="text", nullable=true)
     * @var string
     */
    private $abstract;

    /**
     * @ORM\Column(name="youtube_id", type="string", length=512, nullable=true)
     * @var string|null
     */
    private $youtubeId;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function fromTitle(Meetup $meetup, DateTimeImmutable $time, string $title, string $abstract) : self
    {
        $talk = new self();
        $talk->meetup = $meetup;
        $talk->time = $time;
        $talk->title = $title;
        $talk->abstract = $abstract;
        if ($talk->abstract === '') {
            $talk->abstract = null;
        }
        return $talk;
    }

    public static function fromStandardTalk(
        Meetup $meetup,
        DateTimeImmutable $time,
        Speaker $speaker,
        string $title,
        string $abstract,
        string $youtubeId = null
    ) : self {
        $talk = new self();
        $talk->meetup = $meetup;
        $talk->time = $time;
        $talk->speaker = $speaker;
        $talk->title = $title;
        $talk->abstract = $abstract;
        $talk->youtubeId = $youtubeId;
        if ($talk->abstract === '') {
            $talk->abstract = null;
        }
        if ($talk->youtubeId === '') {
            $talk->youtubeId = null;
        }
        return $talk;
    }

    /**
     * @param DateTimeImmutable $time
     * @param string $title
     * @param string $abstract
     * @param Speaker|null $speaker
     * @param string|null $youtubeId
     * @return void
     */
    public function updateFromData(
        DateTimeImmutable $time,
        string $title,
        string $abstract,
        Speaker $speaker = null,
        string $youtubeId = null
    ) {
        $this->time = $time;
        $this->speaker = $speaker;
        $this->title = $title;
        $this->abstract = $abstract;
        $this->youtubeId = $youtubeId;

        if ($this->abstract === '') {
            $this->abstract = null;
        }

        if ($this->youtubeId === '') {
            $this->youtubeId = null;
        }
    }

    /**
     * @return string|null
     */
    public function getYoutubeId()
    {
        return $this->youtubeId;
    }

    public function getId() : string
    {
        return (string)$this->id;
    }

    public function getMeetup() : Meetup
    {
        return $this->meetup;
    }

    /**
     * @return Speaker|null
     */
    public function getSpeaker()
    {
        return $this->speaker;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getAbstract()
    {
        return $this->abstract;
    }

    public function getTime() : \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->time->format('Y-m-d H:i:s'));
    }
}

<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="video")
 */
/*final */class Video
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Talk::class)
     * @ORM\JoinColumn(name="talk_id", referencedColumnName="id", nullable=false)
     * @var Talk
     */
    private $talk;

    /**
     * @ORM\Column(name="youtubeId", type="string", length=512, nullable=false)
     * @var string
     */
    private $youtubeId;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function fromTalk(Talk $talk, string $youtubeId) : self
    {
        $video = new self();
        $video->talk = $talk;
        $video->youtubeId = $youtubeId;
        return $video;
    }

    public function getTalk() : Talk
    {
        return $this->talk;
    }

    public function getYoutubeId() : string
    {
        return $this->youtubeId;
    }
}

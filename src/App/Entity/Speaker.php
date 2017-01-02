<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="speaker")
 */
/*final */class Speaker
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @ORM\Column(name="full_name", type="string", length=1024, nullable=false)
     * @var string
     */
    private $fullName;

    /**
     * @ORM\Column(name="twitterHandle", type="string", length=1024, nullable=true)
     * @var string|null
     */
    private $twitterHandle;

    /**
     * @ORM\Column(name="biography", type="text", nullable=true)
     * @var string|null
     */
    private $biography;

    /**
     * @ORM\Column(name="imageFilename", type="string", length=1024, nullable=true)
     * @var string|null
     */
    private $imageFilename;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function fromNameAndTwitter(
        string $fullName,
        string $twitterHandle = null,
        string $biography = null,
        string $imageFilename = null
    ) : self {
        $speaker = new self();
        $speaker->fullName = $fullName;
        $speaker->twitterHandle = $twitterHandle;
        $speaker->biography = $biography;
        $speaker->imageFilename = $imageFilename;
        if ($speaker->twitterHandle === '') {
            $speaker->twitterHandle = null;
        }
        if ($speaker->biography === '') {
            $speaker->biography = null;
        }
        if ($speaker->imageFilename === '') {
            $speaker->imageFilename = null;
        }
        return $speaker;
    }

    /**
     * @param string $fullName
     * @param string|null $twitterHandle
     * @param string $biography
     * @param string $imageFilename
     * @return void
     */
    public function updateFromData(
        string $fullName,
        string $twitterHandle = null,
        string $biography = null,
        string $imageFilename = null
    ) {
        $this->fullName = $fullName;
        $this->twitterHandle = $twitterHandle;
        $this->biography = $biography;
        $this->imageFilename = $imageFilename;
        if ($this->twitterHandle === '') {
            $this->twitterHandle = null;
        }
        if ($this->biography === '') {
            $this->biography = null;
        }
        if ($this->imageFilename === '') {
            $this->imageFilename = null;
        }
    }

    public function getId() : string
    {
        return (string)$this->id;
    }

    public function getFullName() : string
    {
        return $this->fullName;
    }

    /**
     * @return string|null
     */
    public function getTwitterHandle()
    {
        return $this->twitterHandle;
    }

    /**
     * @return string|null
     */
    public function getBiography()
    {
        return $this->biography;
    }

    /**
     * @return string|null
     */
    public function getImageFilename()
    {
        return $this->imageFilename;
    }
}

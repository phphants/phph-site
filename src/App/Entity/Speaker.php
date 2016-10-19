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

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function fromNameAndTwitter(string $fullName, string $twitterHandle = null) : self
    {
        $speaker = new self();
        $speaker->fullName = $fullName;
        $speaker->twitterHandle = $twitterHandle;
        if ($speaker->twitterHandle === '') {
            $speaker->twitterHandle = null;
        }
        return $speaker;
    }

    /**
     * @param string $fullName
     * @param string|null $twitterHandle
     * @return void
     */
    public function updateFromData(string $fullName, string $twitterHandle = null)
    {
        $this->fullName = $fullName;
        $this->twitterHandle = $twitterHandle;
        if ($this->twitterHandle === '') {
            $this->twitterHandle = null;
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
}

<?php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="eventbrite_data")
 */
/*final */class EventbriteData
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="guid")
     * @ORM\GeneratedValue(strategy="NONE")
     * @var string
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Meetup::class, inversedBy="eventbriteData")
     * @ORM\JoinColumn(name="meetup_id", referencedColumnName="id", nullable=false)
     * @var Meetup
     */
    private $meetup;

    /**
     * @ORM\Column(name="url", type="string", length=1024, nullable=false)
     * @var string
     */
    private $url;

    /**
     * @ORM\Column(name="eventbriteId", type="string", length=1024, nullable=false)
     * @var string
     */
    private $eventbriteId;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
    }

    public static function fromUrlAndEventbriteId(Meetup $meetup, string $url, string $eventbriteId) : self
    {
        $eventbriteData = new self();
        $eventbriteData->meetup = $meetup;
        $eventbriteData->url = $url;
        $eventbriteData->eventbriteId = $eventbriteId;
        return $eventbriteData;
    }

    public function getUrl() : string
    {
        return $this->url;
    }

    public function getEventbriteId() : string
    {
        return $this->eventbriteId;
    }
}


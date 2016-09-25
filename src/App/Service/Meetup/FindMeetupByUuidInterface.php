<?php
declare(strict_types = 1);

namespace App\Service\Meetup;

use App\Entity\Meetup;
use Ramsey\Uuid\UuidInterface;

interface FindMeetupByUuidInterface
{
    /**
     * @param UuidInterface $uuid
     * @return Meetup
     * @throws Exception\MeetupNotFound
     */
    public function __invoke(UuidInterface $uuid) : Meetup;
}

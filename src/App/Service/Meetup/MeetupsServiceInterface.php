<?php
declare(strict_types = 1);

namespace App\Service\Meetup;

use App\Entity\Meetup;
use DateTimeImmutable;

interface MeetupsServiceInterface
{
    /**
     * Get all meetups after specified date
     *
     * @param DateTimeImmutable $pointInTime
     * @return Meetup[]|array
     */
    public function findMeetupsAfter(DateTimeImmutable $pointInTime) : array;

    /**
     * Get all meetups before specified date
     *
     * @param DateTimeImmutable $pointInTime
     * @return Meetup[]|array
     */
    public function findMeetupsBefore(DateTimeImmutable $pointInTime) : array;
}

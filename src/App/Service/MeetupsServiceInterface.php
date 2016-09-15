<?php
declare(strict_types = 1);

namespace App\Service;

use App\Entity\Meetup;

interface MeetupsServiceInterface
{
    /**
     * Get all future planned meetups
     *
     * @return Meetup[]
     */
    public function getFutureMeetups() : array;

    /**
     * Get all meetups in the past
     *
     * @return Meetup[]
     */
    public function getPastMeetups() : array;
}

<?php
declare(strict_types = 1);

namespace App\Service\Meetup;

use App\Entity\Meetup;

interface GetAllMeetupsInterface
{
    /**
     * Return all Meetup. Returns an empty array if none exist.
     * @return Meetup[]
     */
    public function __invoke() : array;
}

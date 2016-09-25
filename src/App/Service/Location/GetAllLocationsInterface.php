<?php
declare(strict_types = 1);

namespace App\Service\Location;

use App\Entity\Location;

interface GetAllLocationsInterface
{
    /**
     * Return all locations. Returns an empty array if none exist.
     * @return Location[]
     */
    public function __invoke() : array;
}

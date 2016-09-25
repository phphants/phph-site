<?php
declare(strict_types = 1);

namespace App\Service\Location;

use App\Entity\Location;
use Ramsey\Uuid\UuidInterface;

interface FindLocationByUuidInterface
{
    /**
     * @param UuidInterface $uuid
     * @return Location
     * @throws Exception\LocationNotFound
     */
    public function __invoke(UuidInterface $uuid) : Location;
}

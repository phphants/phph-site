<?php
declare(strict_types = 1);

namespace App\Service\Location;

use App\Entity\Location;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

class DoctrineFindLocationByUuid implements FindLocationByUuid
{
    /**
     * @var ObjectRepository
     */
    private $locations;

    public function __construct(ObjectRepository $locations)
    {
        $this->locations = $locations;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(UuidInterface $uuid) : Location
    {
        /** @var Location|null $location */
        $location = $this->locations->findOneBy(['id' => (string)$uuid]);

        if (null === $location) {
            throw Exception\LocationNotFound::fromUuid($uuid);
        }

        return $location;
    }
}

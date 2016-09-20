<?php
declare(strict_types = 1);

namespace App\Service\Location;

use Doctrine\Common\Persistence\ObjectRepository;

class DoctrineGetAllLocations implements GetAllLocationsInterface
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
    public function __invoke() : array
    {
        return $this->locations->findAll();
    }
}

<?php
declare(strict_types = 1);

namespace App\Service;

use App\Entity\EventbriteData;
use App\Entity\Meetup;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineMeetupsService implements MeetupsServiceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get all future planned meetups
     * Entities to be fetched must have Eventbrite data for displaying registration, otherwise it is considered inactive
     *
     * @return Meetup[]
     */
    public function getFutureMeetups() : array
    {
        $query = $this->entityManager->createQuery('
            SELECT meetup
            FROM ' . Meetup::class . ' meetup
                JOIN meetup.eventbriteData eventbriteData 
            WHERE meetup.fromDate >= :fromDate
        ')->setParameters([
            'fromDate' => (new DateTimeImmutable())->setTime(0, 0, 0)
        ]);

        $meetups = $query->getResult();
        return $meetups;
    }

    /**
     * Get all meetups in the past
     *
     * @return Meetup[]
     */
    public function getPastMeetups() : array
    {
        $query = $this->entityManager->createQuery('
            SELECT meetup
            FROM ' . Meetup::class . ' meetup
            WHERE meetup.fromDate < :fromDate
        ')->setParameters([
            'fromDate' => (new DateTimeImmutable())->setTime(0, 0, 0)
        ]);

        $meetups = $query->getResult();
        return $meetups;
    }
}

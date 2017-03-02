<?php
declare(strict_types = 1);

namespace App\Service\Meetup;

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
     * @param DateTimeImmutable $pointInTime
     * @return \App\Entity\Meetup[]|array
     */
    public function findMeetupsAfter(DateTimeImmutable $pointInTime) : array
    {
        $query = $this->entityManager->createQuery('
            SELECT meetup
            FROM ' . Meetup::class . ' meetup
            WHERE meetup.fromDate >= :fromDate
            ORDER BY meetup.fromDate ASC
        ')->setParameters([
            'fromDate' => $pointInTime->setTime(0, 0, 0)
        ]);

        return $query->getResult();
    }

    /**
     * Get all meetups in the past
     *
     * @return Meetup[]
     */
    public function findMeetupsBefore(DateTimeImmutable $pointInTime) : array
    {
        $query = $this->entityManager->createQuery('
            SELECT meetup
            FROM ' . Meetup::class . ' meetup
            WHERE meetup.fromDate < :fromDate
            ORDER BY meetup.fromDate DESC
        ')->setParameters([
            'fromDate' => $pointInTime->setTime(0, 0, 0)
        ]);

        return $query->getResult();
    }
}

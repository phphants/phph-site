<?php
declare(strict_types = 1);

namespace App\Service\Meetup;

use App\Entity\Meetup;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

class DoctrineFindMeetupByUuid implements FindMeetupByUuidInterface
{
    /**
     * @var ObjectRepository
     */
    private $meetups;

    public function __construct(ObjectRepository $meetups)
    {
        $this->meetups = $meetups;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(UuidInterface $uuid) : Meetup
    {
        /** @var Meetup|null $meetup */
        $meetup = $this->meetups->findOneBy(['id' => (string)$uuid]);

        if (null === $meetup) {
            throw Exception\MeetupNotFound::fromUuid($uuid);
        }

        return $meetup;
    }
}

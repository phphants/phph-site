<?php
declare(strict_types = 1);

namespace App\Service\Speaker;

use App\Entity\Speaker;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

class DoctrineFindSpeakerByUuid implements FindSpeakerByUuidInterface
{
    /**
     * @var ObjectRepository
     */
    private $speakers;

    public function __construct(ObjectRepository $speakers)
    {
        $this->speakers = $speakers;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(UuidInterface $uuid) : Speaker
    {
        /** @var Speaker|null $speaker */
        $speaker = $this->speakers->findOneBy(['id' => (string)$uuid]);

        if (null === $speaker) {
            throw Exception\SpeakerNotFound::fromUuid($uuid);
        }

        return $speaker;
    }
}

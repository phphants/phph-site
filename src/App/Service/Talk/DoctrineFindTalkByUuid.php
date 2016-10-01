<?php
declare(strict_types = 1);

namespace App\Service\Talk;

use App\Entity\Talk;
use Doctrine\Common\Persistence\ObjectRepository;
use Ramsey\Uuid\UuidInterface;

class DoctrineFindTalkByUuid implements FindTalkByUuidInterface
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
    public function __invoke(UuidInterface $uuid) : Talk
    {
        /** @var Talk|null $speaker */
        $speaker = $this->speakers->findOneBy(['id' => (string)$uuid]);

        if (null === $speaker) {
            throw Exception\TalkNotFound::fromUuid($uuid);
        }

        return $speaker;
    }
}

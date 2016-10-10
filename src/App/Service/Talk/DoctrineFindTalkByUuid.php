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
    private $talks;

    public function __construct(ObjectRepository $talks)
    {
        $this->talks = $talks;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(UuidInterface $uuid) : Talk
    {
        /** @var Talk|null $talk */
        $talk = $this->talks->findOneBy(['id' => (string)$uuid]);

        if (null === $talk) {
            throw Exception\TalkNotFound::fromUuid($uuid);
        }

        return $talk;
    }
}

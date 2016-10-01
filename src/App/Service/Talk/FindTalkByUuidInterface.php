<?php
declare(strict_types = 1);

namespace App\Service\Talk;

use App\Entity\Talk;
use Ramsey\Uuid\UuidInterface;

interface FindTalkByUuidInterface
{
    /**
     * @param UuidInterface $uuid
     * @return Talk
     * @throws Exception\TalkNotFound
     */
    public function __invoke(UuidInterface $uuid) : Talk;
}

<?php
declare(strict_types = 1);

namespace App\Service\Speaker;

use App\Entity\Speaker;
use Ramsey\Uuid\UuidInterface;

interface FindSpeakerByUuidInterface
{
    /**
     * @param UuidInterface $uuid
     * @return Speaker
     * @throws Exception\SpeakerNotFound
     */
    public function __invoke(UuidInterface $uuid) : Speaker;
}

<?php
declare(strict_types = 1);

namespace App\Service\Speaker\Exception;

use Ramsey\Uuid\UuidInterface;

class SpeakerNotFound extends \RuntimeException
{
    public static function fromUuid(UuidInterface $uuid) : self
    {
        return new self(sprintf(
            'Speaker with uuid %s not found',
            (string)$uuid
        ));
    }
}

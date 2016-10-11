<?php
declare(strict_types = 1);

namespace App\Service\Talk\Exception;

use Ramsey\Uuid\UuidInterface;

class TalkNotFound extends \RuntimeException
{
    public static function fromUuid(UuidInterface $uuid) : self
    {
        return new self(sprintf(
            'Talk with uuid %s not found',
            (string)$uuid
        ));
    }
}

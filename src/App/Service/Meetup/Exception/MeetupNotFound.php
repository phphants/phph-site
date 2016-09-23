<?php
declare(strict_types = 1);

namespace App\Service\Meetup\Exception;

use Ramsey\Uuid\UuidInterface;

class MeetupNotFound extends \RuntimeException
{
    public static function fromUuid(UuidInterface $uuid) : self
    {
        return new self(sprintf(
            'Meetup with uuid %s not found',
            (string)$uuid
        ));
    }
}

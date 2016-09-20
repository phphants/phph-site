<?php
declare(strict_types = 1);

namespace App\Service\Location\Exception;

use Ramsey\Uuid\UuidInterface;

class LocationNotFound extends \RuntimeException
{
    public static function fromUuid(UuidInterface $uuid) : self
    {
        return new self(sprintf(
            'Location with uuid %s not found',
            (string)$uuid
        ));
    }
}

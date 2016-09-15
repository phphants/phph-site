<?php
declare(strict_types = 1);

namespace App\Service\Exception;

final class MeetupDataNotFound extends \RuntimeException
{
    public static function fromFilename(string $filename) : self
    {
        return new self(sprintf('Could not find meetup data file: %s', $filename));
    }
}

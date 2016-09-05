<?php
declare(strict_types = 1);

namespace App\Service\Exception;

final class InvalidMeetupData extends \RuntimeException
{
    public static function fromFilenameAndData(string $filename, $data) : self
    {
        return new self(sprintf(
            'Meetup file %s did not return a valid Meetup entity (was %s)',
            $filename,
            gettype($data)
        ));
    }
}

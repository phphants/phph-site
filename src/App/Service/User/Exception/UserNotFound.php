<?php
declare(strict_types = 1);

namespace App\Service\User\Exception;

class UserNotFound extends \RuntimeException
{
    public static function fromEmail(string $email) : self
    {
        return new self(sprintf('User with email "%s" was not found', $email));
    }
}

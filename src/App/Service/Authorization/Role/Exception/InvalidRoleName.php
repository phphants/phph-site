<?php
declare(strict_types = 1);

namespace App\Service\Authorization\Role\Exception;

final class InvalidRoleName extends \RuntimeException
{
    public static function fromRoleName(string $roleName) : self
    {
        return new self(sprintf('Role "%s" could not be located', $roleName));
    }
}

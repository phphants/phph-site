<?php
declare(strict_types = 1);

namespace App\Service\User;

final class PhpPasswordHash implements PasswordHashInterface
{
    public function hash(string $plaintext) : string
    {
        return password_hash($plaintext, PASSWORD_DEFAULT);
    }

    public function verify(string $plaintext, string $existingHash): bool
    {
        return password_verify($plaintext, $existingHash);
    }
}

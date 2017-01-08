<?php
declare(strict_types = 1);

namespace App\Service\User;

interface PasswordHashInterface
{
    public function hash(string $plaintext) : string;

    public function verify(string $plaintext, string $existingHash) : bool;
}

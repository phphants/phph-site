<?php
declare(strict_types = 1);

namespace App\Service\Authentication\Exception;

class NotAuthenticated extends \RuntimeException
{
    public static function fromNothing() : self
    {
        return new self('There is no user currently authenticated');
    }
}

<?php
declare(strict_types = 1);

namespace App\Service\GoogleRecaptcha;

interface VerifyGoogleRecaptchaInterface
{
    public function __invoke(string $verificationString) : array;
}

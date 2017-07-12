<?php
declare(strict_types = 1);

namespace App\Service\User\Exception;

use App\Service\Authentication\ThirdPartyAuthenticationData;
use Ramsey\Uuid\UuidInterface;

class UserNotFound extends \RuntimeException
{
    public static function fromEmail(string $email) : self
    {
        return new self(sprintf('User with email "%s" was not found', $email));
    }

    public static function fromId(UuidInterface $uuid) : self
    {
        return new self(sprintf('User with ID "%s" was not found', (string)$uuid));
    }

    public static function fromThirdPartyAuthentication(ThirdPartyAuthenticationData $thirdPartyAuthentication) : self
    {
        return new self(sprintf(
            'User for service "%s" with ID "%s" was not found',
            $thirdPartyAuthentication->serviceClass(),
            $thirdPartyAuthentication->uniqueId()
        ));
    }
}

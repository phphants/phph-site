<?php
declare(strict_types = 1);

namespace App\Service\User\Exception;

use App\Service\Authentication\ThirdPartyAuthenticationData;

class UserNotFound extends \RuntimeException
{
    public static function fromEmail(string $email) : self
    {
        return new self(sprintf('User with email "%s" was not found', $email));
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

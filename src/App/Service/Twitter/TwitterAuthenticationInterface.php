<?php
declare(strict_types = 1);

namespace App\Service\Twitter;

use App\Service\Authentication\ThirdPartyAuthenticationData;

interface TwitterAuthenticationInterface
{
    public function createRedirectUrl() : string;

    public function createThirdPartyAuthentication(
        string $oauthToken,
        string $oauthVerifier
    ) : ThirdPartyAuthenticationData;
}

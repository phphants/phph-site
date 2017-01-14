<?php
declare(strict_types = 1);

namespace App\Service\GitHub;

use App\Service\Authentication\ThirdPartyAuthenticationData;

interface GitHubAuthenticationInterface
{
    public function createRedirectUrl() : string;

    public function createThirdPartyAuthentication(string $code, string $state) : ThirdPartyAuthenticationData;
}

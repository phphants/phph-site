<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;
use App\Service\Authentication\ThirdPartyAuthenticationData;

interface FindUserByThirdPartyAuthenticationInterface
{
    /**
     * @param ThirdPartyAuthenticationData $thirdPartyAuthentication
     * @return User
     * @throws Exception\UserNotFound
     */
    public function __invoke(ThirdPartyAuthenticationData $thirdPartyAuthentication) : User;
}

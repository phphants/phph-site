<?php
declare(strict_types = 1);

namespace App\Service\Authentication;

use App\Entity\User;

interface AuthenticationServiceInterface
{
    public function authenticate(string $login, string $password) : bool;

    public function thirdPartyAuthenticate(ThirdPartyAuthenticationData $thirdPartyAuthentication) : bool;

    public function hasIdentity() : bool;

    /**
     * @return User
     * @throws Exception\NotAuthenticated
     */
    public function getIdentity() : User;

    public function clearIdentity() : bool;
}

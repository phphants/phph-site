<?php
declare(strict_types = 1);

namespace App\Service\Authorization;

use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\Authorization\Role\RoleInterface;

final class AuthorizationService implements AuthorizationServiceInterface
{
    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function hasRole(RoleInterface $role): bool
    {
        return $this->authenticationService->hasIdentity()
            && $this->authenticationService->getIdentity()->getRole()->matchesAny([$role]);
    }
}

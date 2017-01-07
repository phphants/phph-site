<?php
declare(strict_types = 1);

namespace App\Service\Authorization;

use App\Service\Authorization\Role\RoleInterface;

interface AuthorizationServiceInterface
{
    public function hasRole(RoleInterface $role) : bool;
}

<?php
declare(strict_types = 1);

namespace App\Service\Authorization\Role;

interface RoleInterface
{
    /**
     * @return string
     */
    public function __toString() : string;

    /**
     * @param self[] $roles
     * @return bool
     */
    public function matchesAny(array $roles) : bool;
}

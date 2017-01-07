<?php
declare(strict_types = 1);

namespace App\Service\Authorization\Role;

final class AdministratorRole implements RoleInterface
{
    const NAME = 'administrator';

    /**
     * @return string
     */
    public function __toString() : string
    {
        return self::NAME;
    }

    /**
     * @param self[] $roles
     * @return bool
     */
    public function matchesAny(array $roles) : bool
    {
        foreach ($roles as $role) {
            if ($role instanceof self) {
                return true;
            }
        }

        return (new AttendeeRole())->matchesAny($roles);
    }
}

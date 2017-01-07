<?php
declare(strict_types = 1);

namespace App\Service\Authorization\Role;

final class AttendeeRole implements RoleInterface
{
    const NAME = 'attendee';

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

        return false;
    }
}

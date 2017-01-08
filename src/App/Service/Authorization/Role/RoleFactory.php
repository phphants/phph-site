<?php
declare(strict_types = 1);

namespace App\Service\Authorization\Role;

final class RoleFactory
{
    /**
     * @var string[]
     */
    private static $roleClassMap = [
        AttendeeRole::NAME => AttendeeRole::class,
        AdministratorRole::NAME => AdministratorRole::class,
    ];

    /**
     * @return string[]
     */
    public static function getKnownRoles() : array
    {
        return array_keys(self::$roleClassMap);
    }

    /**
     * @param string $roleName
     * @return RoleInterface
     * @throws Exception\InvalidRoleName
     */
    public static function getRole(string $roleName) : RoleInterface
    {
        if (array_key_exists($roleName, self::$roleClassMap)) {
            $roleClass = self::$roleClassMap[$roleName];
            return new $roleClass;
        }

        throw Exception\InvalidRoleName::fromRoleName($roleName);
    }
}

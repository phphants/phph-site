<?php
declare(strict_types = 1);

namespace AppTest\Service\Authorization\Role\Exception;

use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;
use App\Service\Authorization\Role\Exception\InvalidRoleName;
use App\Service\Authorization\Role\RoleFactory;

/**
 * @covers \App\Service\Authorization\Role\RoleFactory
 */
final class RoleFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testGetKnownRoles()
    {
        self::assertSame(
            [
                AttendeeRole::NAME,
                AdministratorRole::NAME,
            ],
            RoleFactory::getKnownRoles()
        );
    }

    public function roleMatchesProvider()
    {
        return [
            [AttendeeRole::NAME, AttendeeRole::class],
            [AdministratorRole::NAME, AdministratorRole::class],
        ];
    }

    /**
     * @param string $roleName
     * @param string $expectedClass
     * @dataProvider roleMatchesProvider
     */
    public function testGetRole(string $roleName, string $expectedClass)
    {
        self::assertInstanceOf($expectedClass, RoleFactory::getRole($roleName));
    }

    public function testGetRoleThrowsExceptionWithInvalidRoleName()
    {
        $this->expectException(InvalidRoleName::class);
        RoleFactory::getRole(uniqid('invalidRoleName', true));
    }
}

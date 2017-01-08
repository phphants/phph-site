<?php
declare(strict_types = 1);

namespace AppTest\Service\Authorization\Role\Exception;

use App\Service\Authorization\Role\Exception\InvalidRoleName;

/**
 * @covers \App\Service\Authorization\Role\Exception\InvalidRoleName
 */
final class InvalidRoleNameTest extends \PHPUnit_Framework_TestCase
{
    public function testFromRoleName()
    {
        $roleName = uniqid('roleName', true);
        $exception = InvalidRoleName::fromRoleName($roleName);

        self::assertInstanceOf(InvalidRoleName::class, $exception);
        self::assertStringMatchesFormat('Role "%s" could not be located', $exception->getMessage());
    }
}

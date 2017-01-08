<?php
declare(strict_types = 1);

namespace AppTest\Service\Authorization\Role\Exception;

use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;

/**
 * @covers \App\Service\Authorization\Role\AdministratorRole
 */
final class AdministratorRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testStringify()
    {
        self::assertSame('administrator', (string)new AdministratorRole());
    }

    public function roleMatchesProvider()
    {
        return [
            [true, [new AdministratorRole(), new AttendeeRole()]],
            [true, [new AdministratorRole()]],
            [true, [new AttendeeRole()]],
            [false, []],
        ];
    }

    /**
     * @param bool $shouldMatch
     * @param string[] $roles
     * @dataProvider roleMatchesProvider
     */
    public function testRoleMatches(bool $shouldMatch, array $roles)
    {
        self::assertSame($shouldMatch, (new AdministratorRole())->matchesAny($roles));
    }
}

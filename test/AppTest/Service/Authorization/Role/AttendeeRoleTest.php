<?php
declare(strict_types = 1);

namespace AppTest\Service\Authorization\Role\Exception;

use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;

/**
 * @covers \App\Service\Authorization\Role\AttendeeRole
 */
final class AttendeeRoleTest extends \PHPUnit_Framework_TestCase
{
    public function testStringify()
    {
        self::assertSame('attendee', (string)new AttendeeRole());
    }

    public function roleMatchesProvider()
    {
        return [
            [true, [new AdministratorRole(), new AttendeeRole()]],
            [false, [new AdministratorRole()]],
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
        self::assertSame($shouldMatch, (new AttendeeRole())->matchesAny($roles));
    }
}

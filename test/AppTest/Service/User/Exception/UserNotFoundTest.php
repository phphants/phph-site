<?php
declare(strict_types = 1);

namespace AppTest\Service\User\Exception;

use App\Service\User\Exception\UserNotFound;

/**
 * @covers \App\Service\User\Exception\UserNotFound
 */
class UserNotFoundTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUsername()
    {
        $exception = UserNotFound::fromEmail('foo@bar.com');

        self::assertInstanceOf(UserNotFound::class, $exception);
        self::assertSame('User with email "foo@bar.com" was not found', $exception->getMessage());
    }
}

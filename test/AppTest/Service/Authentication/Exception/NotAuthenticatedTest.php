<?php
declare(strict_types = 1);

namespace AppTest\Service\Authentication\Exception;

use App\Service\Authentication\Exception\NotAuthenticated;

/**
 * @covers \App\Service\Authentication\Exception\NotAuthenticated
 */
class NotAuthenticatedTest extends \PHPUnit_Framework_TestCase
{
    public function testFromUsername()
    {
        $exception = NotAuthenticated::fromNothing();

        self::assertInstanceOf(NotAuthenticated::class, $exception);
        self::assertSame('There is no user currently authenticated', $exception->getMessage());
    }
}

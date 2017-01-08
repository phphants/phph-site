<?php
declare(strict_types = 1);

namespace AppTest\Service\User;

use App\Service\User\PhpPasswordHash;

/**
 * @covers \App\Service\User\PhpPasswordHash
 */
class PhpPasswordHashTest extends \PHPUnit_Framework_TestCase
{
    public function testHash()
    {
        $plaintext = uniqid('password', true);

        self::assertTrue(password_verify($plaintext, (new PhpPasswordHash())->hash($plaintext)));
    }

    public function testVerify()
    {
        $plaintext = uniqid('password', true);

        self::assertTrue((new PhpPasswordHash())->verify($plaintext, password_hash($plaintext, PASSWORD_DEFAULT)));
    }
}

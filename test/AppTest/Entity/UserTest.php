<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\User;

/**
 * @covers \App\Entity\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    private function createValidUser() : User
    {
        $userReflection = new \ReflectionClass(User::class);
        /** @var User $user */
        $user = $userReflection->newInstanceWithoutConstructor();

        $constructor = $userReflection->getConstructor();
        $constructor->setAccessible(true);
        $constructor->invoke($user);

        return $user;
    }

    public function testGetEmail()
    {
        $user = $this->createValidUser();

        $emailProperty = new \ReflectionProperty($user, 'email');
        $emailProperty->setAccessible(true);
        $emailProperty->setValue($user, 'foo@bar.com');

        self::assertSame('foo@bar.com', $user->getEmail());
    }

    public function testPasswordVerification()
    {
        $user = $this->createValidUser();

        $passwordProperty = new \ReflectionProperty($user, 'password');
        $passwordProperty->setAccessible(true);

        // A hash of "correct horse battery staple"
        $passwordProperty->setValue($user, '$2y$10$pnU37zwxwqIjvdmVHI.EouCUMrU3V10x522a3TVeYQMzEitIShzEy');

        self::assertFalse($user->verifyPassword('incorrect password'));
        self::assertTrue($user->verifyPassword('correct horse battery staple'));
    }
}

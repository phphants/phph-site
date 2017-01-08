<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\User;
use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;
use App\Service\User\PhpPasswordHash;

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
        $plaintext = uniqid('plaintext', true);

        $hasher = new PhpPasswordHash();

        $user = User::new('foo@bar.com', $hasher, $plaintext);

        self::assertFalse($user->verifyPassword($hasher, uniqid('incorrect password', true)));
        self::assertTrue($user->verifyPassword($hasher, $plaintext));
    }

    public function roleProvider()
    {
        return [
            'administrator' => [AdministratorRole::NAME, AdministratorRole::class],
            'attendee' => [AttendeeRole::NAME, AttendeeRole::class],
        ];
    }

    /**
     * @param string $roleName
     * @param string $expectedClass
     * @dataProvider roleProvider
     */
    public function testGetRole(string $roleName, string $expectedClass)
    {
        $user = $this->createValidUser();

        $roleProperty = new \ReflectionProperty($user, 'role');
        $roleProperty->setAccessible(true);
        $roleProperty->setValue($user, $roleName);

        self::assertInstanceOf($expectedClass, $user->getRole());
    }
}

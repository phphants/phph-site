<?php
declare(strict_types = 1);

namespace AppTest\Entity;

use App\Entity\User;
use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;
use App\Service\User\PasswordHashInterface;
use App\Service\User\PhpPasswordHash;

/**
 * @covers \App\Entity\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetEmail()
    {
        $email = uniqid('email', true);
        $user = User::new($email, new PhpPasswordHash(), '');

        self::assertSame($email, $user->getEmail());
    }

    public function testPasswordVerification()
    {
        $plaintext = uniqid('plaintext', true);

        $hasher = new PhpPasswordHash();

        $user = User::new('foo@bar.com', $hasher, $plaintext);

        self::assertFalse($user->verifyPassword($hasher, uniqid('incorrect password', true)));
        self::assertTrue($user->verifyPassword($hasher, $plaintext));
    }

    public function testVerifyPasswordReturnsFalseEarlyWhenPasswordIsBlank()
    {
        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);
        $hasher->expects(self::never())->method('verify');

        $originalPassword = uniqid('plaintext', true);
        $user = User::new('foo@bar.com', $hasher, $originalPassword);

        $passwordProperty = new \ReflectionProperty($user, 'password');
        $passwordProperty->setAccessible(true);
        $passwordProperty->setValue($user, '');

        self::assertFalse($user->verifyPassword($hasher, $originalPassword));
        self::assertFalse($user->verifyPassword($hasher, ''));
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
        $user = User::new('foo@bar.com', new PhpPasswordHash(), 'password');

        $roleProperty = new \ReflectionProperty($user, 'role');
        $roleProperty->setAccessible(true);
        $roleProperty->setValue($user, $roleName);

        self::assertInstanceOf($expectedClass, $user->getRole());
    }

    public function testDefaultRoleIsAttendee()
    {
        self::assertInstanceOf(
            AttendeeRole::class,
            User::new('foo@bar.com', new PhpPasswordHash(), 'password')
                ->getRole()
        );
    }
}

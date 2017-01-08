<?php
declare(strict_types = 1);

namespace AppTest\Service\Authentication;

use App\Entity\User;
use App\Service\Authentication\Exception\NotAuthenticated;
use App\Service\Authentication\ZendAuthenticationService;
use App\Service\User\Exception\UserNotFound;
use App\Service\User\FindUserByEmailInterface;
use App\Service\User\PasswordHashInterface;
use Zend\Authentication\Storage\StorageInterface;

/**
 * @covers \App\Service\Authentication\ZendAuthenticationService
 */
class ZendAuthenticationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthenticateReturnsFalseWhenUserNotFound()
    {
        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with('foo@bar.com')->willThrowException(new UserNotFound());

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::never())->method('write');

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);

        self::assertFalse((new ZendAuthenticationService($users, $storage, $hasher))->authenticate('foo@bar.com', ''));
    }

    public function testAuthenticateReturnsFalseWhenPasswordNotValid()
    {
        $email = uniqid('foo@bar.com', true);
        $incorrectPassword = uniqid('incorrect password', true);

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);
        $hasher->expects(self::once())->method('verify')->with($incorrectPassword)->willReturn(false);

        $user = User::new($email, $hasher, uniqid('correct password', true));

        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with($email)->willReturn($user);

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::never())->method('write');

        self::assertFalse(
            (new ZendAuthenticationService($users, $storage, $hasher))->authenticate($email, $incorrectPassword)
        );
    }

    public function testAuthenticateWritesUserToStorageAndReturnsTrueWhenSuccessAuthentication()
    {
        $email = uniqid('foo@bar.com', true);
        $correctPassword = uniqid('correct password', true);

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);
        $hasher->expects(self::once())->method('verify')->with($correctPassword)->willReturn(true);

        $user = User::new($email, $hasher, $correctPassword);

        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with($email)->willReturn($user);

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('write')->with($email);

        self::assertTrue(
            (new ZendAuthenticationService($users, $storage, $hasher))->authenticate(
                $email,
                $correctPassword
            )
        );
    }

    public function testHasIdentityReturnsFalseWhenUserIsNotAuthenticated()
    {
        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('isEmpty')->willReturn(true);

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);

        self::assertFalse((new ZendAuthenticationService($users, $storage, $hasher))->hasIdentity());
    }

    public function testHasIdentityReturnsTrueWhenUserIsAuthenticated()
    {
        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('isEmpty')->willReturn(false);

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);

        self::assertTrue((new ZendAuthenticationService($users, $storage, $hasher))->hasIdentity());
    }

    public function testGetIdentityThrowsExceptionWhenUserIsNotAuthenticated()
    {
        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('read')->willReturn(false);

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);

        $this->expectException(NotAuthenticated::class);
        (new ZendAuthenticationService($users, $storage, $hasher))->getIdentity();
    }

    public function testGetIdentityReturnsUserWhenUserIsAuthenticated()
    {
        $user = $this->createMock(User::class);

        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with('foo@bar.com')->willReturn($user);

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('read')->willReturn('foo@bar.com');

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);

        self::assertSame($user, (new ZendAuthenticationService($users, $storage, $hasher))->getIdentity());
    }

    public function testClearIdentityClearsTheStorage()
    {
        /** @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject $users */
        $users = $this->createMock(FindUserByEmailInterface::class);

        /** @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('clear');

        /** @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject $hasher */
        $hasher = $this->createMock(PasswordHashInterface::class);

        self::assertTrue((new ZendAuthenticationService($users, $storage, $hasher))->clearIdentity());
    }
}

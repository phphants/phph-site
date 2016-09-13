<?php
declare(strict_types = 1);

namespace AppTest\Service\Authentication;

use App\Entity\User;
use App\Service\Authentication\Exception\NotAuthenticated;
use App\Service\Authentication\ZendAuthenticationService;
use App\Service\User\Exception\UserNotFound;
use App\Service\User\FindUserByEmailInterface;
use Zend\Authentication\Storage\StorageInterface;

/**
 * @covers \App\Service\Authentication\ZendAuthenticationService
 */
class ZendAuthenticationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testAuthenticateReturnsFalseWhenUserNotFound()
    {
        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with('foo@bar.com')->willThrowException(new UserNotFound());

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::never())->method('write');

        self::assertFalse((new ZendAuthenticationService($users, $storage))->authenticate('foo@bar.com', ''));
    }

    public function testAuthenticateReturnsFalseWhenPasswordNotValid()
    {
        $user = $this->createMock(User::class);
        $user->expects(self::once())->method('verifyPassword')->with('incorrect password')->willReturn(false);

        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with('foo@bar.com')->willReturn($user);

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::never())->method('write');

        self::assertFalse(
            (new ZendAuthenticationService($users, $storage))->authenticate('foo@bar.com', 'incorrect password')
        );
    }

    public function testAuthenticateWritesUserToStorageAndReturnsTrueWhenSuccessAuthentication()
    {
        $user = $this->createMock(User::class);
        $user->expects(self::once())->method('verifyPassword')->with('correct horse battery staple')->willReturn(true);
        $user->expects(self::once())->method('getEmail')->willReturn('foo@bar.com');

        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with('foo@bar.com')->willReturn($user);

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('write')->with('foo@bar.com');

        self::assertTrue(
            (new ZendAuthenticationService($users, $storage))->authenticate(
                'foo@bar.com',
                'correct horse battery staple'
            )
        );
    }

    public function testHasIdentityReturnsTrueWhenUserIsAuthenticated()
    {
        $users = $this->createMock(FindUserByEmailInterface::class);

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('isEmpty')->willReturn(true);

        self::assertFalse((new ZendAuthenticationService($users, $storage))->hasIdentity());
    }

    public function testHasIdentityReturnsFalseWhenUserIsNotAuthenticated()
    {
        $users = $this->createMock(FindUserByEmailInterface::class);

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('isEmpty')->willReturn(false);

        self::assertTrue((new ZendAuthenticationService($users, $storage))->hasIdentity());
    }

    public function testGetIdentityThrowsExceptionWhenUserIsNotAuthenticated()
    {
        $users = $this->createMock(FindUserByEmailInterface::class);

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('read')->willReturn(false);

        $this->expectException(NotAuthenticated::class);
        (new ZendAuthenticationService($users, $storage))->getIdentity();
    }

    public function testGetIdentityReturnsUserWhenUserIsAuthenticated()
    {
        $user = $this->createMock(User::class);

        $users = $this->createMock(FindUserByEmailInterface::class);
        $users->expects(self::once())->method('__invoke')->with('foo@bar.com')->willReturn($user);

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('read')->willReturn('foo@bar.com');

        self::assertSame($user, (new ZendAuthenticationService($users, $storage))->getIdentity());
    }

    public function testClearIdentityClearsTheStorage()
    {
        $users = $this->createMock(FindUserByEmailInterface::class);

        $storage = $this->createMock(StorageInterface::class);
        $storage->expects(self::once())->method('clear');

        self::assertTrue((new ZendAuthenticationService($users, $storage))->clearIdentity());
    }
}

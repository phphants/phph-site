<?php
declare(strict_types = 1);

namespace AppTest\Service\Authentication;

use App\Entity\User;
use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Service\Authentication\Exception\NotAuthenticated;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\Authentication\ZendAuthenticationService;
use App\Service\User\Exception\UserNotFound;
use App\Service\User\FindUserByEmailInterface;
use App\Service\User\FindUserByThirdPartyAuthenticationInterface;
use App\Service\User\PasswordHashInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Zend\Authentication\Storage\StorageInterface;

/**
 * @covers \App\Service\Authentication\ZendAuthenticationService
 */
class ZendAuthenticationServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FindUserByEmailInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findUsersByEmail;

    /**
     * @var FindUserByThirdPartyAuthenticationInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $findUsersByThirdPartyAuthentication;

    /**
     * @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $entityManager;

    /**
     * @var StorageInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $storage;

    /**
     * @var PasswordHashInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $hasher;

    /**
     * @var ZendAuthenticationService
     */
    private $authenticationService;

    public function setUp()
    {
        $this->findUsersByEmail = $this->createMock(FindUserByEmailInterface::class);
        $this->findUsersByThirdPartyAuthentication = $this->createMock(
            FindUserByThirdPartyAuthenticationInterface::class
        );
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->storage = $this->createMock(StorageInterface::class);
        $this->hasher = $this->createMock(PasswordHashInterface::class);

        $this->authenticationService = new ZendAuthenticationService(
            $this->findUsersByEmail,
            $this->findUsersByThirdPartyAuthentication,
            $this->entityManager,
            $this->storage,
            $this->hasher
        );
    }

    public function testAuthenticateReturnsFalseWhenUserNotFound()
    {
        $this->findUsersByEmail->expects(self::once())
            ->method('__invoke')
            ->with('foo@bar.com')
            ->willThrowException(new UserNotFound());

        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');

        $this->storage->expects(self::never())->method('write');

        self::assertFalse($this->authenticationService->authenticate('foo@bar.com', ''));
    }

    public function testAuthenticateReturnsFalseWhenPasswordNotValid()
    {
        $email = uniqid('foo@bar.com', true);
        $correctPassword = uniqid('correct password', true);
        $incorrectPassword = uniqid('incorrect password', true);
        $hash = uniqid('hashed password', true);

        $this->hasher->expects(self::once())->method('hash')->with($correctPassword)->willReturn($hash);
        $this->hasher->expects(self::once())->method('verify')->with($incorrectPassword, $hash)->willReturn(false);

        $user = User::new($email, 'My Name', $this->hasher, $correctPassword);

        $this->findUsersByEmail->expects(self::once())->method('__invoke')->with($email)->willReturn($user);

        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');

        $this->storage->expects(self::never())->method('write');

        self::assertFalse($this->authenticationService->authenticate($email, $incorrectPassword));
    }

    public function testAuthenticateWritesUserToStorageAndReturnsTrueWhenSuccessAuthentication()
    {
        $email = uniqid('foo@bar.com', true);
        $correctPassword = uniqid('correct password', true);
        $hash = uniqid('hashed password', true);

        $this->hasher->expects(self::once())->method('hash')->with($correctPassword)->willReturn($hash);
        $this->hasher->expects(self::once())->method('verify')->with($correctPassword, $hash)->willReturn(true);

        $user = User::new($email, 'My Name', $this->hasher, $correctPassword);

        $this->findUsersByEmail->expects(self::once())->method('__invoke')->with($email)->willReturn($user);

        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');

        $this->storage->expects(self::once())->method('write')->with($email);

        self::assertTrue($this->authenticationService->authenticate($email, $correctPassword));
    }

    public function testHasIdentityReturnsFalseWhenUserIsNotAuthenticated()
    {
        $this->findUsersByEmail->expects(self::never())->method('__invoke');
        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');
        $this->storage->expects(self::once())->method('isEmpty')->willReturn(true);

        self::assertFalse($this->authenticationService->hasIdentity());
    }

    public function testHasIdentityReturnsTrueWhenUserIsAuthenticated()
    {
        $this->findUsersByEmail->expects(self::never())->method('__invoke');
        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');
        $this->storage->expects(self::once())->method('isEmpty')->willReturn(false);

        self::assertTrue($this->authenticationService->hasIdentity());
    }

    public function testGetIdentityThrowsExceptionWhenUserIsNotAuthenticated()
    {
        $this->findUsersByEmail->expects(self::never())->method('__invoke');
        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');
        $this->storage->expects(self::once())->method('read')->willReturn(false);

        $this->expectException(NotAuthenticated::class);
        $this->authenticationService->getIdentity();
    }

    public function testGetIdentityReturnsUserWhenUserIsAuthenticated()
    {
        $user = $this->createMock(User::class);

        $this->findUsersByEmail->expects(self::once())->method('__invoke')->with('foo@bar.com')->willReturn($user);
        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');
        $this->storage->expects(self::once())->method('read')->willReturn('foo@bar.com');

        self::assertSame($user, $this->authenticationService->getIdentity());
    }

    public function testClearIdentityClearsTheStorage()
    {
        $this->findUsersByEmail->expects(self::never())->method('__invoke');
        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');
        $this->storage->expects(self::once())->method('clear');

        self::assertTrue($this->authenticationService->clearIdentity());
    }

    public function testUserCreatedWhenThirdPartyAuthenticatesAndUserDoesNotExist()
    {
        $email = uniqid('email', true);
        $displayName = uniqid('displayName', true);
        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            uniqid('id', true),
            $email,
            $displayName,
            []
        );

        $this->findUsersByThirdPartyAuthentication->expects(self::once())
            ->method('__invoke')
            ->with($authData)
            ->willThrowException(new UserNotFound());

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $this->entityManager->expects(self::once())
            ->method('persist')
            ->with(self::callback(function (User $newUser) use ($email, $displayName) {
                self::assertSame($email, $newUser->getEmail());
                self::assertSame($displayName, $newUser->displayName());
                return true;
            }));

        $this->storage->expects(self::once())->method('isEmpty')->willReturn(true);
        $this->storage->expects(self::once())->method('write')->with($email);

        $this->authenticationService->thirdPartyAuthenticate($authData);
    }

    public function testUserLoggedInWhenUserAlreadyExistsAndNotAlreadyLoggedIn(): void
    {
        $email = uniqid('email', true);
        $displayName = uniqid('displayName', true);
        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            uniqid('id', true),
            $email,
            $displayName,
            []
        );
        $user = User::fromThirdPartyAuthentication($authData);

        $this->findUsersByThirdPartyAuthentication->expects(self::once())
            ->method('__invoke')
            ->with($authData)
            ->willReturn($user);

        $this->entityManager->expects(self::never())->method('transactional');
        $this->entityManager->expects(self::never())->method('persist');

        $this->storage->expects(self::once())->method('isEmpty')->willReturn(true);
        $this->storage->expects(self::once())->method('write')->with($email);

        $this->authenticationService->thirdPartyAuthenticate($authData);
    }

    public function testNewThirdPartyAuthIsAddedWhenUserAlreadyLoggedInAndDoesNotHaveServiceAddedYet(): void
    {
        $email = uniqid('email', true);
        $displayName = uniqid('displayName', true);
        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            uniqid('id', true),
            $email,
            $displayName,
            []
        );

        $user = User::new($email, $displayName, new PhpPasswordHash(), uniqid('password', true));
        self::assertCount(0, $user->thirdPartyLogins());

        $this->findUsersByThirdPartyAuthentication->expects(self::never())->method('__invoke');

        $this->entityManager->expects(self::once())->method('transactional')->willReturnCallback('call_user_func');
        $this->entityManager->expects(self::never())->method('persist');

        $this->findUsersByEmail->expects(self::once())->method('__invoke')->with($email)->willReturn($user);

        $this->storage->expects(self::once())->method('isEmpty')->willReturn(false);
        $this->storage->expects(self::once())->method('read')->willReturn($email);

        $this->authenticationService->thirdPartyAuthenticate($authData);

        self::assertCount(1, $user->thirdPartyLogins());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Service\Authorization;

use App\Entity\User;
use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\Authorization\AuthorizationService;
use App\Service\Authorization\Role\AdministratorRole;
use App\Service\Authorization\Role\AttendeeRole;

/**
 * @covers \App\Service\Authorization\AuthorizationService
 */
class AuthorizationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testHasRoleReturnsFalseWhenNotAuthenticated()
    {
        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(false);
        $authentication->expects(self::never())->method('getIdentity');

        $authorization = new AuthorizationService($authentication);
        self::assertFalse($authorization->hasRole(new AttendeeRole()));
    }

    public function testHasRoleReturnsFalseWhenAuthenticatedButInvalidRole()
    {
        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);
        $user->expects(self::once())->method('getRole')->willReturn(new AttendeeRole());

        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(true);
        $authentication->expects(self::once())->method('getIdentity')->willReturn($user);

        $authorization = new AuthorizationService($authentication);
        self::assertFalse($authorization->hasRole(new AdministratorRole()));
    }

    public function testHasRoleReturnsTrueWhenAuthenticatedButValidAttendeeNeedsAttendee()
    {
        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);
        $user->expects(self::once())->method('getRole')->willReturn(new AttendeeRole());

        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(true);
        $authentication->expects(self::once())->method('getIdentity')->willReturn($user);

        $authorization = new AuthorizationService($authentication);
        self::assertTrue($authorization->hasRole(new AttendeeRole()));
    }

    public function testHasRoleReturnsTrueWhenAuthenticatedButValidAdminNeedsAdmin()
    {
        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);
        $user->expects(self::once())->method('getRole')->willReturn(new AdministratorRole());

        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(true);
        $authentication->expects(self::once())->method('getIdentity')->willReturn($user);

        $authorization = new AuthorizationService($authentication);
        self::assertTrue($authorization->hasRole(new AdministratorRole()));
    }

    public function testHasRoleReturnsTrueWhenAuthenticatedButValidAdminNeedsAttendee()
    {
        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);
        $user->expects(self::once())->method('getRole')->willReturn(new AdministratorRole());

        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(true);
        $authentication->expects(self::once())->method('getIdentity')->willReturn($user);

        $authorization = new AuthorizationService($authentication);
        self::assertTrue($authorization->hasRole(new AttendeeRole()));
    }
}

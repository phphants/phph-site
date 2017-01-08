<?php
declare(strict_types = 1);

namespace AppTest\View\Helper;

use App\Service\Authentication\AuthenticationServiceInterface;
use App\Service\Authorization\AuthorizationServiceInterface;
use App\Service\Authorization\Role\AdministratorRole;
use App\View\Helper\User;

/**
 * @covers \App\View\Helper\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testIsLoggedInReturnsTrueWhenLoggedIn()
    {
        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(true);

        /** @var AuthorizationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authorization */
        $authorization = $this->createMock(AuthorizationServiceInterface::class);

        self::assertTrue((new User($authentication, $authorization))->isLoggedIn());
    }

    public function testIsLoggedInReturnsFalseWhenNotLoggedIn()
    {
        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(false);

        /** @var AuthorizationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authorization */
        $authorization = $this->createMock(AuthorizationServiceInterface::class);

        self::assertFalse((new User($authentication, $authorization))->isLoggedIn());
    }

    public function testIsAdministratorReturnsTrueWhenHasRole()
    {
        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);

        /** @var AuthorizationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authorization */
        $authorization = $this->createMock(AuthorizationServiceInterface::class);
        $authorization ->expects(self::once())
            ->method('hasRole')
            ->with(self::isInstanceOf(AdministratorRole::class))
            ->willReturn(true);

        self::assertTrue((new User($authentication, $authorization))->isAdministrator());
    }

    public function testIsAdministratorReturnsFalseWhenDoesNotHaveRole()
    {
        /** @var AuthenticationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authentication */
        $authentication = $this->createMock(AuthenticationServiceInterface::class);

        /** @var AuthorizationServiceInterface|\PHPUnit_Framework_MockObject_MockObject $authorization */
        $authorization = $this->createMock(AuthorizationServiceInterface::class);
        $authorization ->expects(self::once())
            ->method('hasRole')
            ->with(self::isInstanceOf(AdministratorRole::class))
            ->willReturn(false);

        self::assertFalse((new User($authentication, $authorization))->isAdministrator());
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\View\Helper;

use App\Service\Authentication\AuthenticationServiceInterface;
use App\View\Helper\User;

/**
 * @covers \App\View\Helper\User
 */
class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testIsLoggedInReturnsTrueWhenLoggedIn()
    {
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(true);

        self::assertTrue((new User($authentication))->isLoggedIn());
    }

    public function testIsLoggedInReturnsFalseWhenNotLoggedIn()
    {
        $authentication = $this->createMock(AuthenticationServiceInterface::class);
        $authentication->expects(self::once())->method('hasIdentity')->willReturn(false);

        self::assertFalse((new User($authentication))->isLoggedIn());
    }
}

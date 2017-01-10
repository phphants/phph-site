<?php
declare(strict_types = 1);

namespace AppTest\Entity\UserThirdPartyAuthentication;

use App\Entity\User;
use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Entity\UserThirdPartyAuthentication\UserThirdPartyAuthentication;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use Assert\AssertionFailedException;

/**
 * @covers \App\Entity\UserThirdPartyAuthentication\UserThirdPartyAuthentication
 */
class UserThirdPartyAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionIsThrownWhenRequestedDiscriminatorIsNotAValidThirdPartyAuthenticationClass()
    {
        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);

        $this->expectException(AssertionFailedException::class);
        UserThirdPartyAuthentication::new(
            $user,
            ThirdPartyAuthenticationData::new(
                \stdClass::class,
                uniqid('id', true),
                uniqid('email', true),
                uniqid('displayName', true),
                []
            )
        );
    }

    public function testNewReturnsValidInstance()
    {
        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);

        $id = uniqid('id', true);

        $thirdPartyAuth = UserThirdPartyAuthentication::new(
            $user,
            ThirdPartyAuthenticationData::new(
                Twitter::class,
                $id,
                uniqid('email', true),
                uniqid('displayName', true),
                []
            )
        );

        self::assertInstanceOf(UserThirdPartyAuthentication::class, $thirdPartyAuth);
        self::assertInstanceOf(Twitter::class, $thirdPartyAuth);
        self::assertSame($id, $thirdPartyAuth->uniqueId());
        self::assertSame($user, $thirdPartyAuth->user());
    }
}

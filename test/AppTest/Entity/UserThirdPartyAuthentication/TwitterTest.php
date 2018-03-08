<?php
declare(strict_types = 1);

namespace AppTest\Entity\UserThirdPartyAuthentication;

use App\Entity\User;
use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Service\Authentication\ThirdPartyAuthenticationData;

/**
 * @covers \App\Entity\UserThirdPartyAuthentication\Twitter
 */
class TwitterTest extends \PHPUnit_Framework_TestCase
{
    public function testRouteNameForAuthenticatingReturnsCorrectly(): void
    {
        self::assertSame('account-twitter-authenticate', Twitter::routeNameForAuthentication());
    }

    /**
     * @covers \App\Entity\UserThirdPartyAuthentication\UserThirdPartyAuthentication::type
     * @throws \ReflectionException
     */
    public function testTypeIsReturnedCorrectly(): void
    {
        self::assertSame('Twitter', Twitter::type());
    }

    public function testTwitterHandleReturnsWhenSet()
    {
        $twitterHandle = uniqid('twitterHandle', true);
        $user = User::fromThirdPartyAuthentication(
            ThirdPartyAuthenticationData::new(
                Twitter::class,
                uniqid('id', true),
                uniqid('email', true),
                uniqid('displayName', true),
                [
                    'twitter' => $twitterHandle,
                ]
            )
        );

        self::assertSame($twitterHandle, $user->twitterHandle());

        /** @var Twitter $userThirdPartyAuth */
        $userThirdPartyAuth = array_values($user->thirdPartyLogins())[0];
        self::assertSame($twitterHandle, $userThirdPartyAuth->displayName());
    }

    public function testTwitterHandleReturnsNullWhenNotSet()
    {
        $user = User::fromThirdPartyAuthentication(
            ThirdPartyAuthenticationData::new(
                Twitter::class,
                uniqid('id', true),
                uniqid('email', true),
                uniqid('displayName', true),
                []
            )
        );

        self::assertNull($user->twitterHandle());
    }
}

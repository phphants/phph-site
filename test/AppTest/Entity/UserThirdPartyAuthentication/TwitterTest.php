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

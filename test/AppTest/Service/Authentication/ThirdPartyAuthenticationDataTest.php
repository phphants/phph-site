<?php
declare(strict_types = 1);

namespace AppTest\Service\Authentication;

use App\Entity\UserThirdPartyAuthentication\Twitter;
use App\Service\Authentication\ThirdPartyAuthenticationData;

/**
 * @covers \App\Service\Authentication\ThirdPartyAuthenticationData
 */
class ThirdPartyAuthenticationDataTest extends \PHPUnit_Framework_TestCase
{
    public function testNewCreatesValidInstance()
    {
        $id = uniqid('id', true);
        $email = uniqid('email', true);
        $displayName = uniqid('displayName', true);
        $userData = uniqid('userData', true);

        $authData = ThirdPartyAuthenticationData::new(
            Twitter::class,
            $id,
            $email,
            $displayName,
            [
                'userData' => $userData,
            ]
        );

        self::assertSame(Twitter::class, $authData->serviceClass());
        self::assertSame($id, $authData->uniqueId());
        self::assertSame($email, $authData->email());
        self::assertSame($displayName, $authData->displayName());
        self::assertSame(
            [
                'userData' => $userData,
                'email' => $email,
                'displayName' => $displayName,
            ],
            $authData->userData()
        );
    }
}

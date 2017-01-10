<?php
declare(strict_types = 1);

namespace AppTest\Service\Twitter;

use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\Twitter\TwitterAuthentication;
use League\OAuth1\Client\Credentials\TemporaryCredentials;
use League\OAuth1\Client\Credentials\TokenCredentials;
use League\OAuth1\Client\Server\Twitter;
use League\OAuth1\Client\Server\User;
use Zend\Session\Container as SessionContainer;

/**
 * @covers \App\Service\Twitter\TwitterAuthentication
 */
class TwitterAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateRedirectUrl()
    {
        $identifier = uniqid('identifier', true);
        $secret = uniqid('secret', true);
        $url = uniqid('url', true);

        $temporaryCredentials = new TemporaryCredentials();
        $temporaryCredentials->setIdentifier($identifier);
        $temporaryCredentials->setSecret($secret);

        /** @var Twitter|\PHPUnit_Framework_MockObject_MockObject $twitter */
        $twitter = $this->createMock(Twitter::class);
        $twitter->expects(self::once())->method('getTemporaryCredentials')->willReturn($temporaryCredentials);
        $twitter->expects(self::once())->method('getAuthorizationUrl')->with($temporaryCredentials)->willReturn($url);

        $session = new SessionContainer();

        self::assertSame($url, (new TwitterAuthentication($twitter, $session))->createRedirectUrl());

        self::assertSame(
            json_encode([
                'identifier' => $identifier,
                'secret' => $secret,
            ]),
            $session->offsetGet(TwitterAuthentication::SESSION_KEY)
        );
    }

    public function testCreateThirdPartyAuthentication()
    {
        $identifier = uniqid('identifier', true);
        $secret = uniqid('secret', true);
        $oauthToken = uniqid('oauthToken', true);
        $oauthVerifier = uniqid('oauthVerifier', true);

        $tokenCredentials = new TokenCredentials();
        $oauthUser = new User();
        $oauthUser->uid = uniqid('uid', true);
        $oauthUser->email = uniqid('email', true);
        $oauthUser->name = uniqid('name', true);
        $oauthUser->nickname = uniqid('nickname', true);

        /** @var Twitter|\PHPUnit_Framework_MockObject_MockObject $twitter */
        $twitter = $this->createMock(Twitter::class);
        $twitter->expects(self::once())
            ->method('getTokenCredentials')
            ->with(
                self::callback(function (TemporaryCredentials $temporaryCredentials) use ($identifier, $secret) {
                    self::assertSame($identifier, $temporaryCredentials->getIdentifier());
                    self::assertSame($secret, $temporaryCredentials->getSecret());
                    return true;
                }),
                $oauthToken,
                $oauthVerifier
            )
            ->willReturn($tokenCredentials);
        $twitter->expects(self::once())->method('getUserDetails')->with($tokenCredentials)->willReturn($oauthUser);

        $session = new SessionContainer();
        $session->offsetSet(
            TwitterAuthentication::SESSION_KEY,
            json_encode([
                'identifier' => $identifier,
                'secret' => $secret,
            ])
        );

        $authData = (new TwitterAuthentication($twitter, $session))
            ->createThirdPartyAuthentication($oauthToken, $oauthVerifier);

        self::assertInstanceOf(ThirdPartyAuthenticationData::class, $authData);
        self::assertSame(\App\Entity\UserThirdPartyAuthentication\Twitter::class, $authData->serviceClass());
        self::assertSame($oauthUser->uid, $authData->uniqueId());
        self::assertSame($oauthUser->email, $authData->email());
        self::assertSame($oauthUser->name, $authData->displayName());
        self::assertSame(
            [
                'twitter' => $oauthUser->nickname,
                'email' => $oauthUser->email,
                'displayName' => $oauthUser->name,
            ],
            $authData->userData()
        );
    }
}

<?php
declare(strict_types = 1);

namespace AppTest\Service\GitHub;

use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\GitHub\GitHubAuthentication;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use League\OAuth2\Client\Token\AccessToken;
use Zend\Session\Container as SessionContainer;

/**
 * @covers \App\Service\GitHub\GitHubAuthentication
 */
class GitHubAuthenticationTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateRedirectUrl()
    {
        $state = uniqid('state', true);
        $url = uniqid('url', true);

        /** @var Github|\PHPUnit_Framework_MockObject_MockObject $github */
        $github = $this->createMock(Github::class);
        $github->expects(self::once())
            ->method('getAuthorizationUrl')
            ->with([
                'scope' => ['user', 'user:email'],
            ])
            ->willReturn($url);
        $github->expects(self::once())->method('getState')->willReturn($state);

        $session = new SessionContainer();

        self::assertSame($url, (new GitHubAuthentication($github, $session))->createRedirectUrl());

        self::assertSame($state, $session->offsetGet(GitHubAuthentication::SESSION_KEY));
    }

    public function testStateMismatchCausesAuthException()
    {
        $session = new SessionContainer();
        $session->offsetSet(GitHubAuthentication::SESSION_KEY, uniqid('state', true));

        /** @var Github|\PHPUnit_Framework_MockObject_MockObject $github */
        $github = $this->createMock(Github::class);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid oauth state');
        (new GitHubAuthentication($github, $session))->createThirdPartyAuthentication(
            uniqid('code', true),
            uniqid('state', true)
        );
    }

    public function testCreateThirdPartyAuthentication()
    {
        $code = uniqid('code', true);
        $state = uniqid('state', true);

        $accessToken = new AccessToken([
            'access_token' => uniqid('accessToken', true),
        ]);

        $userId = random_int(100000, 1000000);
        $email = uniqid('email', true);
        $name = uniqid('name', true);
        $login = uniqid('login', true);
        $resourceOwner = new GithubResourceOwner([
            'id' => $userId,
            'email' => $email,
            'name' => $name,
            'login' => $login,
        ]);

        /** @var Github|\PHPUnit_Framework_MockObject_MockObject $github */
        $github = $this->createMock(Github::class);
        $github->expects(self::once())
            ->method('getAccessToken')
            ->with(
                'authorization_code',
                [
                    'code' => $code
                ]
            )
            ->willReturn($accessToken);
        $github->expects(self::once())->method('getResourceOwner')->with($accessToken)->willReturn($resourceOwner);

        $session = new SessionContainer();
        $session->offsetSet(GitHubAuthentication::SESSION_KEY, $state);

        $authData = (new GitHubAuthentication($github, $session))
            ->createThirdPartyAuthentication($code, $state);

        self::assertInstanceOf(ThirdPartyAuthenticationData::class, $authData);
        self::assertSame(\App\Entity\UserThirdPartyAuthentication\GitHub::class, $authData->serviceClass());
        self::assertSame((string)$userId, $authData->uniqueId());
        self::assertSame($email, $authData->email());
        self::assertSame($name, $authData->displayName());
        self::assertSame(
            [
                'username' => $login,
                'email' => $email,
                'displayName' => $name,
            ],
            $authData->userData()
        );
    }
}

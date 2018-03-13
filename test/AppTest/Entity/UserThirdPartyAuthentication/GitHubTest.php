<?php
declare(strict_types = 1);

namespace AppTest\Entity\UserThirdPartyAuthentication;

use App\Entity\User;
use App\Entity\UserThirdPartyAuthentication\GitHub;
use App\Service\Authentication\ThirdPartyAuthenticationData;

/**
 * @covers \App\Entity\UserThirdPartyAuthentication\GitHub
 */
class GitHubTest extends \PHPUnit_Framework_TestCase
{
    public function testRouteNameForAuthenticatingReturnsCorrectly(): void
    {
        self::assertSame('account-github-authenticate', GitHub::routeNameForAuthentication());
    }

    /**
     * @covers \App\Entity\UserThirdPartyAuthentication\UserThirdPartyAuthentication::type
     * @throws \ReflectionException
     */
    public function testTypeIsReturnedCorrectly(): void
    {
        self::assertSame('GitHub', GitHub::type());
    }

    public function testGitHubUsernameReturnsWhenSet()
    {
        $githubUsername = uniqid('githubUsername', true);
        $user = User::fromThirdPartyAuthentication(
            ThirdPartyAuthenticationData::new(
                GitHub::class,
                uniqid('id', true),
                uniqid('email', true),
                uniqid('displayName', true),
                [
                    'username' => $githubUsername,
                ]
            )
        );

        self::assertSame($githubUsername, $user->githubUsername());
    }

    public function testGitHubUsernameReturnsNullWhenNotSet()
    {
        $id = uniqid('id', true);
        $user = User::fromThirdPartyAuthentication(
            ThirdPartyAuthenticationData::new(
                GitHub::class,
                $id,
                uniqid('email', true),
                uniqid('displayName', true),
                []
            )
        );

        self::assertSame($id, $user->githubUsername());
    }
}

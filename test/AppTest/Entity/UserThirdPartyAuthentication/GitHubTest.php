<?php
declare(strict_types = 1);

namespace AppTest\Entity\UserThirdPartyAuthentication;

use App\Entity\User;
use App\Entity\UserThirdPartyAuthentication\GitHub;
use App\Entity\UserThirdPartyAuthentication\UserThirdPartyAuthentication;
use App\Service\Authentication\ThirdPartyAuthenticationData;
use App\Service\User\PhpPasswordHash;

/**
 * @covers \App\Entity\UserThirdPartyAuthentication\GitHub
 */
class GitHubTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \App\Entity\UserThirdPartyAuthentication\UserThirdPartyAuthentication::type
     * @throws \ReflectionException
     */
    public function testTypeIsReturnedCorrectly(): void
    {
        self::assertSame(
            'GitHub',
            UserThirdPartyAuthentication::new(
                User::new(
                    uniqid('email', true),
                    uniqid('displayName', true),
                    new PhpPasswordHash(),
                    uniqid('password', true)
                ),
                ThirdPartyAuthenticationData::new(
                    GitHub::class,
                    uniqid('id', true),
                    uniqid('email', true),
                    uniqid('displayName', true),
                    [
                        'username' => uniqid('gitHubUsername', true),
                    ]
                )
            )::type()
        );
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

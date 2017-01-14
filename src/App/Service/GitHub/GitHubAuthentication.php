<?php
declare(strict_types = 1);

namespace App\Service\GitHub;

use App\Service\Authentication\ThirdPartyAuthenticationData;
use League\OAuth2\Client\Provider\Github;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use Zend\Session\Container as SessionContainer;

final class GitHubAuthentication implements GitHubAuthenticationInterface
{
    const SESSION_KEY = 'App_Service_GitHub_Authentication';

    /**
     * @var Github
     */
    private $github;

    /**
     * @var SessionContainer
     */
    private $session;

    public function __construct(Github $github, SessionContainer $session)
    {
        $this->github = $github;
        $this->session = $session;
    }

    public function createRedirectUrl() : string
    {
        $authUrl = $this->github->getAuthorizationUrl([
            'scope' => ['user', 'user:email'],
        ]);

        $this->session->offsetSet(
            self::SESSION_KEY,
            $this->github->getState()
        );

        return $authUrl;
    }

    private function verifyState(string $givenState) : void
    {
        $storedState = $this->session->offsetGet(self::SESSION_KEY);
        if (!hash_equals($storedState, $givenState)) {
            throw new \InvalidArgumentException('Invalid oauth state');
        }
    }

    public function createThirdPartyAuthentication(string $code, string $state) : ThirdPartyAuthenticationData
    {
        $this->verifyState($state);

        $token = $this->github->getAccessToken(
            'authorization_code',
            [
                'code' => $code,
            ]
        );

        /** @var GithubResourceOwner $userDetails */
        $userDetails = $this->github->getResourceOwner($token);

        return ThirdPartyAuthenticationData::new(
            \App\Entity\UserThirdPartyAuthentication\GitHub::class,
            (string)$userDetails->getId(),
            $userDetails->getEmail(),
            $userDetails->getName(),
            [
                'username' => $userDetails->getNickname(),
            ]
        );
    }
}

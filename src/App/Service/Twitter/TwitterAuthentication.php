<?php
declare(strict_types = 1);

namespace App\Service\Twitter;

use App\Service\Authentication\ThirdPartyAuthenticationData;
use League\OAuth1\Client\Credentials\TemporaryCredentials;
use League\OAuth1\Client\Server\Twitter;
use Zend\Session\Container as SessionContainer;

final class TwitterAuthentication implements TwitterAuthenticationInterface
{
    const SESSION_KEY = 'App_Service_Twitter_Authentication';

    /**
     * @var Twitter
     */
    private $twitter;

    /**
     * @var SessionContainer
     */
    private $session;

    public function __construct(Twitter $twitter, SessionContainer $session)
    {
        $this->twitter = $twitter;
        $this->session = $session;
    }

    public function createRedirectUrl() : string
    {
        $temporaryCredentials = $this->twitter->getTemporaryCredentials();

        $this->session->offsetSet(
            self::SESSION_KEY,
            json_encode([
                'identifier' => $temporaryCredentials->getIdentifier(),
                'secret' => $temporaryCredentials->getSecret(),
            ])
        );

        return $this->twitter->getAuthorizationUrl($temporaryCredentials);
    }

    public function createThirdPartyAuthentication(string $oauthToken, string $oauthVerifier) : ThirdPartyAuthenticationData
    {
        $sessionData = json_decode($this->session->offsetGet(self::SESSION_KEY), true);

        $temporaryCredentials = new TemporaryCredentials();
        $temporaryCredentials->setIdentifier($sessionData['identifier']);
        $temporaryCredentials->setSecret($sessionData['secret']);

        $tokenCredentials = $this->twitter->getTokenCredentials($temporaryCredentials, $oauthToken, $oauthVerifier);

        $userDetails = $this->twitter->getUserDetails($tokenCredentials);

        return ThirdPartyAuthenticationData::new(
            \App\Entity\UserThirdPartyAuthentication\Twitter::class,
            $userDetails->uid,
            $userDetails->email,
            $userDetails->name,
            [
                'twitter' => $userDetails->nickname,
            ]
        );
    }
}

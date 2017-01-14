<?php
declare(strict_types = 1);

namespace App\Service\GitHub;

use Interop\Container\ContainerInterface;
use League\OAuth2\Client\Provider\Github;
use Zend\Session\Container as SessionContainer;

/**
 * @codeCoverageIgnore
 */
class GitHubAuthenticationFactory
{
    public function __invoke(ContainerInterface $container) : GitHubAuthentication
    {
        return new GitHubAuthentication(
            new Github($container->get('config')['phph-site']['github']),
            new SessionContainer(GitHubAuthentication::class)
        );
    }
}

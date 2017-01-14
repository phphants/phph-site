<?php
declare(strict_types = 1);

namespace App\Service\Twitter;

use Interop\Container\ContainerInterface;
use League\OAuth1\Client\Server\Twitter;
use Zend\Session\Container as SessionContainer;

/**
 * @codeCoverageIgnore
 */
class TwitterAuthenticationFactory
{
    public function __invoke(ContainerInterface $container) : TwitterAuthentication
    {
        return new TwitterAuthentication(
            new Twitter($container->get('config')['phph-site']['twitter']),
            new SessionContainer(TwitterAuthentication::class)
        );
    }
}

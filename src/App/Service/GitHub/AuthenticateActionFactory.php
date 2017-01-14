<?php
declare(strict_types = 1);

namespace App\Service\GitHub;

use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
class AuthenticateActionFactory
{
    public function __invoke(ContainerInterface $container) : AuthenticateAction
    {
        return new AuthenticateAction(
            $container->get(GitHubAuthenticationInterface::class)
        );
    }
}

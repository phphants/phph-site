<?php
declare(strict_types = 1);

namespace App\Service\GitHub;

use App\Service\Authentication\AuthenticationServiceInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @codeCoverageIgnore
 */
class CallbackActionFactory
{
    public function __invoke(ContainerInterface $container) : CallbackAction
    {
        return new CallbackAction(
            $container->get(GitHubAuthenticationInterface::class),
            $container->get(AuthenticationServiceInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

<?php
declare(strict_types = 1);

namespace App\Service\Authorization;

use App\Service\Authentication\AuthenticationServiceInterface;
use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
final class Factory
{
    public function __invoke(ContainerInterface $container) : AuthorizationService
    {
        return new AuthorizationService(
            $container->get(AuthenticationServiceInterface::class)
        );
    }
}

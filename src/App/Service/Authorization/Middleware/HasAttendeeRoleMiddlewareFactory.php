<?php
declare(strict_types = 1);

namespace App\Service\Authorization\Middleware;

use App\Service\Authorization\AuthorizationServiceInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class HasAttendeeRoleMiddlewareFactory
{
    public function __invoke(ContainerInterface $container) : HasAttendeeRoleMiddleware
    {
        return new HasAttendeeRoleMiddleware(
            $container->get(AuthorizationServiceInterface::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}

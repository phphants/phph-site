<?php
declare(strict_types=1);

namespace App\Middleware;

use Interop\Container\ContainerInterface;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class AuthenticationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Authentication(
            $container->get(AuthenticationServiceInterface::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}

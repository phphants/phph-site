<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Service\Authentication\AuthenticationServiceInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class UserFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : User
    {
        return new User($container->get(AuthenticationServiceInterface::class));
    }
}

<?php
declare(strict_types=1);

namespace App\Action\Account;

use App\Service\Authentication\AuthenticationServiceInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @codeCoverageIgnore
 */
final class LogoutActionFactory
{
    public function __invoke(ContainerInterface $container) : LogoutAction
    {
        return new LogoutAction(
            $container->get(AuthenticationServiceInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

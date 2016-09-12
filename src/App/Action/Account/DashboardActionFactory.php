<?php
declare(strict_types=1);

namespace App\Action\Account;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class DashboardActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new DashboardAction($container->get(TemplateRendererInterface::class));
    }
}

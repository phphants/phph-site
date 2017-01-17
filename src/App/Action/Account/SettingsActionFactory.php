<?php
declare(strict_types=1);

namespace App\Action\Account;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class SettingsActionFactory
{
    public function __invoke(ContainerInterface $container) : SettingsAction
    {
        return new SettingsAction($container->get(TemplateRendererInterface::class));
    }
}

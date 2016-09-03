<?php
declare(strict_types=1);

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class TeamActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new TeamAction($container->get(TemplateRendererInterface::class));
    }
}

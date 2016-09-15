<?php
declare(strict_types=1);

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class SponsorsActionFactory
{
    public function __invoke(ContainerInterface $container) : SponsorsAction
    {
        return new SponsorsAction($container->get(TemplateRendererInterface::class));
    }
}

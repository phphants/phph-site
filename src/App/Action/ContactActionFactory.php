<?php
declare(strict_types=1);

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ContactActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ContactAction($container->get(TemplateRendererInterface::class));
    }
}

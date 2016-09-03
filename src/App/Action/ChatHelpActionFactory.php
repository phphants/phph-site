<?php
declare(strict_types=1);

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ChatHelpActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ChatHelpAction($container->get(TemplateRendererInterface::class));
    }
}

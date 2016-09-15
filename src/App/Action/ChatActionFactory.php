<?php
declare(strict_types=1);

namespace App\Action;

use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ChatActionFactory
{
    public function __invoke(ContainerInterface $container) : ChatAction
    {
        return new ChatAction($container->get(TemplateRendererInterface::class));
    }
}

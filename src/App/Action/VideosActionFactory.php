<?php
declare(strict_types=1);

namespace App\Action;

use App\Service\Talk\FindTalksWithVideoInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class VideosActionFactory
{
    public function __invoke(ContainerInterface $container) : VideosAction
    {
        return new VideosAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(FindTalksWithVideoInterface::class)
        );
    }
}

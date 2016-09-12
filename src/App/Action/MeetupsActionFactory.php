<?php
declare(strict_types=1);

namespace App\Action;

use App\Service\Meetup\MeetupsServiceInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class MeetupsActionFactory
{
    public function __invoke(ContainerInterface $container) : MeetupsAction
    {
        return new MeetupsAction(
            $container->get(MeetupsServiceInterface::class),
            $container->get(TemplateRendererInterface::class)
        );
    }
}

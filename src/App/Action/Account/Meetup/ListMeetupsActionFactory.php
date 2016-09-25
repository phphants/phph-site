<?php
declare(strict_types=1);

namespace App\Action\Account\Meetup;

use App\Service\Meetup\GetAllMeetupsInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ListMeetupsActionFactory
{
    public function __invoke(ContainerInterface $container) : ListMeetupsAction
    {
        return new ListMeetupsAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(GetAllMeetupsInterface::class)
        );
    }
}

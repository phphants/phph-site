<?php
declare(strict_types=1);

namespace App\Action\Account\Location;

use App\Service\Location\GetAllLocationsInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ListLocationsActionFactory
{
    public function __invoke(ContainerInterface $container) : ListLocationsAction
    {
        return new ListLocationsAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(GetAllLocationsInterface::class)
        );
    }
}

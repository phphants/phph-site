<?php
declare(strict_types=1);

namespace App\Action;

use App\Service\MeetupsService;
use Interop\Container\ContainerInterface;

/**
 * @codeCoverageIgnore
 */
final class MeetupsIcsActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new MeetupsIcsAction(
            $container->get(MeetupsService::class)
        );
    }
}

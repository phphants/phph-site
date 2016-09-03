<?php
declare(strict_types=1);

namespace App\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class MeetupsServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new MeetupsService(
            realpath($container->get('config')['phph-site']['meetups-data-path'])
        );
    }
}

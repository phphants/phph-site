<?php
declare(strict_types=1);

namespace App\Service\Location;

use App\Entity\Location;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class GetAllLocationsFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : GetAllLocationsInterface {
        return new DoctrineGetAllLocations(
            $container->get(EntityManagerInterface::class)->getRepository(Location::class)
        );
    }
}

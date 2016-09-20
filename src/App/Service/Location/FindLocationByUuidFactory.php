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
final class FindLocationByUuidFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : FindLocationByUuid {
        return new DoctrineFindLocationByUuid(
            $container->get(EntityManagerInterface::class)->getRepository(Location::class)
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Service\Meetup;

use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class MeetupsServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null) : DoctrineMeetupsService
    {
        return new DoctrineMeetupsService(
            $container->get(EntityManagerInterface::class)
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Service\Speaker;

use App\Entity\Speaker;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class GetAllSpeakersFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : GetAllSpeakersInterface {
        return new DoctrineGetAllSpeakers(
            $container->get(EntityManagerInterface::class)->getRepository(Speaker::class)
        );
    }
}

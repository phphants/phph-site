<?php
declare(strict_types=1);

namespace App\Service\Video;

use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class GetAllVideosFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : GetAllVideosInterface {
        return new DoctrineGetAllVideos(
            $container->get(EntityManagerInterface::class)->getRepository(Video::class)
        );
    }
}

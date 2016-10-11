<?php
declare(strict_types=1);

namespace App\Service\Talk;

use App\Entity\Talk;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
final class FindTalkByUuidFactory implements FactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : FindTalkByUuidInterface {
        return new DoctrineFindTalkByUuid(
            $container->get(EntityManagerInterface::class)->getRepository(Talk::class)
        );
    }
}

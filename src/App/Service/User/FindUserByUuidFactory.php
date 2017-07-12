<?php
declare(strict_types = 1);

namespace App\Service\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
class FindUserByUuidFactory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @throws \Interop\Container\Exception\NotFoundException
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : DoctrineFindUserByUuid {
        return new DoctrineFindUserByUuid(
            $container->get(EntityManagerInterface::class)->getRepository(User::class)
        );
    }
}

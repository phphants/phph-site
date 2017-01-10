<?php
declare(strict_types = 1);

namespace App\Service\Authentication;

use App\Service\User\DoctrineFindUserByThirdPartyAuthentication;
use App\Service\User\FindUserByEmailInterface;
use App\Service\User\PhpPasswordHash;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Authentication\Storage\Session;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * @codeCoverageIgnore
 */
class Factory implements FactoryInterface
{
    /**
     * {@inheritdoc}
     * @throws \Interop\Container\Exception\NotFoundException
     */
    public function __invoke(
        ContainerInterface $container,
        $requestedName,
        array $options = null
    ) : ZendAuthenticationService {
        $entityManager = $container->get(EntityManagerInterface::class);
        return new ZendAuthenticationService(
            $container->get(FindUserByEmailInterface::class),
            new DoctrineFindUserByThirdPartyAuthentication($entityManager),
            $entityManager,
            new Session(),
            new PhpPasswordHash()
        );
    }
}

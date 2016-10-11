<?php
declare(strict_types=1);

namespace App\Action\Account\Talk;

use App\Service\Talk\FindTalkByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @codeCoverageIgnore
 */
final class DeleteTalkActionFactory
{
    public function __invoke(ContainerInterface $container) : DeleteTalkAction
    {
        return new DeleteTalkAction(
            $container->get(EntityManagerInterface::class),
            $container->get(FindTalkByUuidInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

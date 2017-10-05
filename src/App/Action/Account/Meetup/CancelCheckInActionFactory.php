<?php
declare(strict_types=1);

namespace App\Action\Account\Meetup;

use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\User\FindUserByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

/**
 * @codeCoverageIgnore
 */
final class CancelCheckInActionFactory
{
    public function __invoke(ContainerInterface $container) : CancelCheckInAction
    {
        return new CancelCheckInAction(
            $container->get(EntityManagerInterface::class),
            $container->get(FindMeetupByUuidInterface::class),
            $container->get(FindUserByUuidInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

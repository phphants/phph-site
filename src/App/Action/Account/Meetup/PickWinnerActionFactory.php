<?php
declare(strict_types=1);

namespace App\Action\Account\Meetup;

use App\Service\Meetup\FindMeetupByUuidInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class PickWinnerActionFactory
{
    /**
     * @param ContainerInterface $container
     * @return PickWinnerAction
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container) : PickWinnerAction
    {
        return new PickWinnerAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(FindMeetupByUuidInterface::class)
        );
    }
}

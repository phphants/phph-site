<?php
declare(strict_types=1);

namespace App\Action\Account\Meetup;

use App\Service\Meetup\FindMeetupByUuidInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ViewMeetupActionFactory
{
    public function __invoke(ContainerInterface $container) : ViewMeetupAction
    {
        return new ViewMeetupAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(FindMeetupByUuidInterface::class)
        );
    }
}

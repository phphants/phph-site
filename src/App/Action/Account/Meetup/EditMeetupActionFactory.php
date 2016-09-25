<?php
declare(strict_types=1);

namespace App\Action\Account\Meetup;

use App\Form\Account\MeetupForm;
use App\Service\Location\FindLocationByUuidInterface;
use App\Service\Location\GetAllLocationsInterface;
use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\Speaker\GetAllSpeakersInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class EditMeetupActionFactory
{
    public function __invoke(ContainerInterface $container) : EditMeetupAction
    {
        return new EditMeetupAction(
            $container->get(TemplateRendererInterface::class),
            new MeetupForm(
                $container->get(GetAllLocationsInterface::class),
                $container->get(GetAllSpeakersInterface::class)
            ),
            $container->get(EntityManagerInterface::class),
            $container->get(FindMeetupByUuidInterface::class),
            $container->get(FindLocationByUuidInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

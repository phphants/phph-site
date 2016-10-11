<?php
declare(strict_types=1);

namespace App\Action\Account\Talk;

use App\Form\Account\TalkForm;
use App\Service\Meetup\FindMeetupByUuidInterface;
use App\Service\Speaker\FindSpeakerByUuidInterface;
use App\Service\Speaker\GetAllSpeakersInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class AddTalkActionFactory
{
    public function __invoke(ContainerInterface $container) : AddTalkAction
    {
        return new AddTalkAction(
            $container->get(TemplateRendererInterface::class),
            new TalkForm($container->get(GetAllSpeakersInterface::class)),
            $container->get(EntityManagerInterface::class),
            $container->get(FindMeetupByUuidInterface::class),
            $container->get(FindSpeakerByUuidInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

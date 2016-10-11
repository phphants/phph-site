<?php
declare(strict_types=1);

namespace App\Action\Account\Talk;

use App\Form\Account\TalkForm;
use App\Service\Speaker\FindSpeakerByUuidInterface;
use App\Service\Speaker\GetAllSpeakersInterface;
use App\Service\Talk\FindTalkByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class EditTalkActionFactory
{
    public function __invoke(ContainerInterface $container) : EditTalkAction
    {
        return new EditTalkAction(
            $container->get(TemplateRendererInterface::class),
            new TalkForm($container->get(GetAllSpeakersInterface::class)),
            $container->get(EntityManagerInterface::class),
            $container->get(FindTalkByUuidInterface::class),
            $container->get(FindSpeakerByUuidInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

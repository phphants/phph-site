<?php
declare(strict_types=1);

namespace App\Action\Account\Speaker;

use App\Form\Account\SpeakerForm;
use App\Service\Speaker\FindSpeakerByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class EditSpeakerActionFactory
{
    public function __invoke(ContainerInterface $container) : EditSpeakerAction
    {
        return new EditSpeakerAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(FindSpeakerByUuidInterface::class),
            new SpeakerForm(),
            $container->get(EntityManagerInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

<?php
declare(strict_types=1);

namespace App\Action\Account\Speaker;

use App\Form\Account\SpeakerForm;
use App\Service\Speaker\MoveSpeakerHeadshotInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class AddSpeakerActionFactory
{
    public function __invoke(ContainerInterface $container) : AddSpeakerAction
    {
        return new AddSpeakerAction(
            $container->get(TemplateRendererInterface::class),
            new SpeakerForm(),
            $container->get(EntityManagerInterface::class),
            $container->get(UrlHelper::class),
            $container->get(MoveSpeakerHeadshotInterface::class)
        );
    }
}

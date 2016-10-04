<?php
declare(strict_types=1);

namespace App\Action\Account\Speaker;

use App\Service\Speaker\GetAllSpeakersInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class ListSpeakersActionFactory
{
    public function __invoke(ContainerInterface $container) : ListSpeakersAction
    {
        return new ListSpeakersAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(GetAllSpeakersInterface::class)
        );
    }
}

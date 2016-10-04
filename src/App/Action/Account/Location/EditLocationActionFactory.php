<?php
declare(strict_types=1);

namespace App\Action\Account\Location;

use App\Form\Account\LocationForm;
use App\Service\Location\FindLocationByUuidInterface;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class EditLocationActionFactory
{
    public function __invoke(ContainerInterface $container) : EditLocationAction
    {
        return new EditLocationAction(
            $container->get(TemplateRendererInterface::class),
            $container->get(FindLocationByUuidInterface::class),
            new LocationForm(),
            $container->get(EntityManagerInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

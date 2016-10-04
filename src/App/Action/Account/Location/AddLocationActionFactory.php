<?php
declare(strict_types=1);

namespace App\Action\Account\Location;

use App\Form\Account\LocationForm;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Template\TemplateRendererInterface;

/**
 * @codeCoverageIgnore
 */
final class AddLocationActionFactory
{
    public function __invoke(ContainerInterface $container) : AddLocationAction
    {
        return new AddLocationAction(
            $container->get(TemplateRendererInterface::class),
            new LocationForm(),
            $container->get(EntityManagerInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}

<?php
declare(strict_types = 1);

namespace App\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;
use Zend\View\HelperPluginManager;

/**
 * @codeCoverageIgnore
 */
class HelperPluginManagerDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(
        ContainerInterface $container,
        $name,
        callable $callback,
        array $options = null
    ) : HelperPluginManager {
        $helperPluginManager = $callback();

        $helperPluginManager->get('basePath')->setBasePath($container->get('config')['templates']['base_path']);

        return $helperPluginManager;
    }
}

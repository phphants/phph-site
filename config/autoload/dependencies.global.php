<?php
declare(strict_types=1);

use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    'dependencies' => [
        'invokables' => [
            Helper\ServerUrlHelper::class => Helper\ServerUrlHelper::class,
        ],
        'factories' => [
            Application::class => ApplicationFactory::class,
            Helper\UrlHelper::class => Helper\UrlHelperFactory::class,
            App\Service\MeetupsServiceInterface::class => App\Service\MeetupsServiceFactory::class,
            Doctrine\ORM\EntityManager::class => ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
        'delegators' => [
            Zend\View\HelperPluginManager::class => [
                App\View\HelperPluginManagerDelegatorFactory::class
            ],
        ],
    ],
];

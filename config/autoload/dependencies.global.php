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
            App\Service\User\FindUserByEmailInterface::class => App\Service\User\FindUserByEmailFactory::class,
            App\Service\Meetup\MeetupsServiceInterface::class => App\Service\Meetup\MeetupsServiceFactory::class,
            App\Service\Authentication\AuthenticationServiceInterface::class => App\Service\Authentication\Factory::class,
            Doctrine\ORM\EntityManagerInterface::class => ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
        'delegators' => [
            Zend\View\HelperPluginManager::class => [
                App\View\HelperPluginManagerDelegatorFactory::class
            ],
        ],
    ],
];

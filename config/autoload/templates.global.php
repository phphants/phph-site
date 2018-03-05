<?php
declare(strict_types=1);

return [
    'dependencies' => [
        'factories' => [
            'Zend\Expressive\FinalHandler' =>
                Zend\Expressive\Container\TemplatedErrorHandlerFactory::class,

            Zend\Expressive\Template\TemplateRendererInterface::class =>
                Zend\Expressive\ZendView\ZendViewRendererFactory::class,

            Zend\View\HelperPluginManager::class =>
                Zend\Expressive\ZendView\HelperPluginManagerFactory::class,
        ],
    ],

    'templates' => [
        'base_path' => '/',
        'layout' => 'layout/default',
        'map' => [
            'layout/default' => 'templates/layout/default.phtml',
            'error/error' => 'templates/error/error.phtml',
            'error/404' => 'templates/error/404.phtml',
            'error/403' => 'templates/error/403.phtml',
        ],
        'paths' => [
            'app' => ['templates/app'],
            'account' => ['templates/app/account'],
            'layout' => ['templates/layout'],
            'error' => ['templates/error'],
        ],
    ],

    'view_helpers' => [
        'invokables' => [
            App\View\Helper\TwitterLinkOrName::class => App\View\Helper\TwitterLinkOrName::class,
        ],
        'factories' => [
            App\View\Helper\IsDebug::class => App\View\Helper\IsDebugFactory::class,
            App\View\Helper\User::class => App\View\Helper\UserFactory::class,
            App\View\Helper\SpeakerHeadshot::class => App\View\Helper\SpeakerHeadshotFactory::class,
        ],
        'aliases' => [
            'twitterLinkOrName' => App\View\Helper\TwitterLinkOrName::class,
            'isDebug' => App\View\Helper\IsDebug::class,
            'user' => App\View\Helper\User::class,
            'speakerHeadshot' => App\View\Helper\SpeakerHeadshot::class,
        ],
    ],
];

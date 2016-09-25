<?php
declare(strict_types=1);

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
            App\Action\SubscribeAction::class => App\Action\SubscribeAction::class,
        ],
        'factories' => [
            App\Action\IndexAction::class => App\Action\IndexActionFactory::class,
            App\Action\MeetupsAction::class => App\Action\MeetupsActionFactory::class,
            App\Action\MeetupsIcsAction::class => App\Action\MeetupsIcsActionFactory::class,
            App\Action\ContactAction::class => App\Action\ContactActionFactory::class,
            App\Action\SponsorsAction::class => App\Action\SponsorsActionFactory::class,
            App\Action\VideosAction::class => App\Action\VideosActionFactory::class,
            App\Action\CodeOfConductAction::class => App\Action\CodeOfConductActionFactory::class,
            App\Action\ChatAction::class => App\Action\ChatActionFactory::class,
            App\Action\ChatHelpAction::class => App\Action\ChatHelpActionFactory::class,
            App\Action\TeamAction::class => App\Action\TeamActionFactory::class,
            App\Action\Account\LoginAction::class => App\Action\Account\LoginActionFactory::class,
            App\Action\Account\DashboardAction::class => App\Action\Account\DashboardActionFactory::class,
            App\Action\Account\LogoutAction::class => App\Action\Account\LogoutActionFactory::class,
            App\Action\Account\Meetup\AddMeetupAction::class => App\Action\Account\Meetup\AddMeetupActionFactory::class,
            App\Action\Account\Meetup\EditMeetupAction::class => App\Action\Account\Meetup\EditMeetupActionFactory::class,
            App\Action\Account\Meetup\ViewMeetupAction::class => App\Action\Account\Meetup\ViewMeetupActionFactory::class,
            App\Action\Account\Meetup\ListMeetupsAction::class => App\Action\Account\Meetup\ListMeetupsActionFactory::class,
            App\Middleware\Authentication::class => App\Middleware\AuthenticationFactory::class,
        ],
    ],
    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => App\Action\IndexAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'meetups',
            'path' => '/meetups',
            'middleware' => App\Action\MeetupsAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'meetups-ics',
            'path' => '/meetups.ics',
            'middleware' => App\Action\MeetupsIcsAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'contact',
            'path' => '/contact',
            'middleware' => App\Action\ContactAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'sponsors',
            'path' => '/sponsors',
            'middleware' => App\Action\SponsorsAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'videos',
            'path' => '/videos',
            'middleware' => App\Action\VideosAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'code-of-conduct',
            'path' => '/code-of-conduct',
            'middleware' => App\Action\CodeOfConductAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'chat',
            'path' => '/chat',
            'middleware' => App\Action\ChatAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'chat-help',
            'path' => '/chat/help',
            'middleware' => App\Action\ChatHelpAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'team',
            'path' => '/team',
            'middleware' => App\Action\TeamAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'subscribe',
            'path' => '/subscribe',
            'middleware' => App\Action\SubscribeAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'account-login',
            'path' => '/account/login',
            'middleware' => App\Action\Account\LoginAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'account-dashboard',
            'path' => '/account/dashboard',
            'middleware' => [
                App\Middleware\Authentication::class,
                App\Action\Account\DashboardAction::class,
            ],
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'account-meetups-list',
            'path' => '/account/meetups',
            'middleware' => [
                App\Middleware\Authentication::class,
                App\Action\Account\Meetup\ListMeetupsAction::class,
            ],
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'account-meetup-add',
            'path' => '/account/meetup/add',
            'middleware' => [
                App\Middleware\Authentication::class,
                App\Action\Account\Meetup\AddMeetupAction::class,
            ],
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'account-meetup-view',
            'path' => '/account/meetup/{uuid}',
            'middleware' => [
                App\Middleware\Authentication::class,
                App\Action\Account\Meetup\ViewMeetupAction::class,
            ],
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'account-meetup-edit',
            'path' => '/account/meetup/{uuid}/edit',
            'middleware' => [
                App\Middleware\Authentication::class,
                App\Action\Account\Meetup\EditMeetupAction::class,
            ],
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'account-logout',
            'path' => '/account/logout',
            'middleware' => [
                App\Middleware\Authentication::class,
                App\Action\Account\LogoutAction::class,
            ],
            'allowed_methods' => ['GET'],
        ],
    ],
];

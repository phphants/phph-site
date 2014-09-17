<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Phph\Site\Controller\IndexController' => 'Phph\Site\Controller\IndexController',
            'Phph\Site\Controller\ContactController' => 'Phph\Site\Controller\ContactController',
            'Phph\Site\Controller\SponsorsController' => 'Phph\Site\Controller\SponsorsController',
            'Phph\Site\Controller\VideosController' => 'Phph\Site\Controller\VideosController',
            'Phph\Site\Controller\CodeOfConductController' => 'Phph\Site\Controller\CodeOfConductController',
            'Phph\Site\Controller\ChatController' => 'Phph\Site\Controller\ChatController',
            'Phph\Site\Controller\TeamController' => 'Phph\Site\Controller\TeamController',
        ),
        'factories' => array(
            'Phph\Site\Controller\MeetupsController' => 'Phph\Site\Controller\MeetupsControllerFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
            'MeetupsService' => 'Phph\Site\Service\MeetupsServiceFactory',
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\IndexController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'meetups' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/meetups',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\MeetupsController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'meetups-ical' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/meetups.ics',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\MeetupsController',
                        'action'  => 'ical',
                    ),
                ),
            ),
            'contact' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/contact',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\ContactController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'sponsors' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/sponsors',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\SponsorsController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'videos' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/videos',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\VideosController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'codeofconduct' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/code-of-conduct',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\CodeOfConductController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'chat' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/chat',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\ChatController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'chat-help' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/chat/help',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\ChatController',
                        'action'  => 'help',
                    ),
                ),
            ),
            'team' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/team',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\TeamController',
                        'action'  => 'index',
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'default' => array(
            'home' => array(
                'label' => 'Home',
                'route' => 'home',
            ),
            'meetups' => array(
                'label' => 'Meetups',
                'route' => 'meetups',
            ),
            'videos' => array(
                'label' => 'Videos',
                'route' => 'videos',
            ),
            'sponsors' => array(
                'label' => 'Sponsors',
                'route' => 'sponsors',
            ),
            'contact' => array(
                'label' => 'Contact',
                'route' => 'contact',
            ),
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'renderMeetup' => 'Phph\Site\View\Helper\RenderMeetup',
        ),
    ),
    'view_manager' => array(
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/header' => __DIR__ . '/../view/layout/header.phtml',
            'layout/footer' => __DIR__ . '/../view/layout/footer.phtml',
        ),
        'template_path_stack' => array(
            'Site' => __DIR__ . '/../view',
        ),
    ),
    'phph-site' => array(
        'meetupsDataPath' => __DIR__ . '/../../../../data/meetups/',
    ),
);

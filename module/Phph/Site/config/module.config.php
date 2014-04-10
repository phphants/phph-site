<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Phph\Site\Controller\IndexController' => 'Phph\Site\Controller\IndexController',
            'Phph\Site\Controller\JoinUsController' => 'Phph\Site\Controller\JoinUsController',
            'Phph\Site\Controller\ContactController' => 'Phph\Site\Controller\ContactController',
            'Phph\Site\Controller\SponsorsController' => 'Phph\Site\Controller\SponsorsController',
            'Phph\Site\Controller\VideosController' => 'Phph\Site\Controller\VideosController',
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
            'join' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/join',
                    'defaults' => array(
                        'controller' => 'Phph\Site\Controller\JoinUsController',
                        'action'  => 'index',
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
            'join' => array(
                'label' => 'Join Us',
                'route' => 'join',
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
        'template_map' => array(
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

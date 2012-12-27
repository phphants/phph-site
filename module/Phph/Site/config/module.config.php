<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Phph\Site\Controller\IndexController' => 'Phph\Site\Controller\IndexController',
            'Phph\Site\Controller\JoinUsController' => 'Phph\Site\Controller\JoinUsController',
            'Phph\Site\Controller\ContactController' => 'Phph\Site\Controller\ContactController',
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
        ),
        'template_path_stack' => array(
            'Site' => __DIR__ . '/../view',
        ),
    ),
    'phph-site' => array(
        'meetupsDataPath' => __DIR__ . '/../../../../data/meetups/',
    ),
);

<?php

return array(
	'controllers' => array(
		'invokables' => array(
			'Phph\Site\Controller\Index' => 'Phph\Site\Controller\IndexController',
			'Phph\Site\Controller\Meetups' => 'Phph\Site\Controller\MeetupsController',
		),
	),
	'service_manager' => array(
		'factories' => array(
			'Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
		),
	),
	'router' => array(
		'routes' => array(
			'home' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/',
					'defaults' => array(
						'controller' => 'Phph\Site\Controller\Index',
						'action'  => 'index',
					),
				),
			),
			'meetups' => array(
				'type' => 'Zend\Mvc\Router\Http\Literal',
				'options' => array(
					'route' => '/meetups',
					'defaults' => array(
						'controller' => 'Phph\Site\Controller\Meetups',
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
);
<?php

return array(
    'controllers' => array(
        'factories' => array(
            'Phph\Members\Controller\MemberController' => 'Phph\Members\Controller\MemberControllerFactory',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Phph\Members\Service\MemberService' => 'Phph\Members\Service\MemberServiceFactory'
        ),
    ),
    'router' => array(
        'routes' => array(
            'member-index' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/members',
                    'defaults' => array(
                        'controller' => 'Phph\Members\Controller\MemberController',
                        'action'  => 'index',
                    ),
                ),
            ),
            'member-register' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route' => '/members/register',
                    'defaults' => array(
                        'controller' => 'Phph\Members\Controller\MemberController',
                        'action'  => 'register',
                    ),
                ),
            ),
            'member-confirm' => array(
                'type' => 'Zend\Mvc\Router\Http\Segment',
                'options' => array(
                    'route' => '/members/confirm/:key',
                    'defaults' => array(
                        'controller' => 'Phph\Members\Controller\MemberController',
                        'action'  => 'confirm',
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
        'default' => array(
            'members' => array(
                'label' => 'Members',
                'route' => 'member-index',
            ),
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'renderMember' => 'Phph\Members\View\Helper\RenderMember',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Members' => __DIR__ . '/../view',
        ),
    ),
    'phph-site' => array(
        'membersDataPath' => __DIR__ . '/../../../../data/members/members.json',
    ),
);

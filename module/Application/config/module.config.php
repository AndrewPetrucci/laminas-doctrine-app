<?php

declare(strict_types=1);

namespace Application;

use Application\Controller\ChessController;
use Application\Controller\SkillTreeController;
use Application\View\Helper\NavbarHelper;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
             'chess' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/chess',
                    'defaults' => [
                        'controller' => ChessController::class,
                        'action'     => 'index',
                    ],
                    'order' => 1,
                ],
            ],
            'skilltree' => [
                'type' => 'Literal',
                'options' => [
                    'route'    => '/skilltree',
                    'defaults' => [
                        'controller' => SkillTreeController::class,
                        'action'     => 'index',
                    ],
                    'order' => 2,
                ],
            ],
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                    'order' => 0,
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                    'order' => 99,
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            ChessController::class => InvokableFactory::class,
            SkillTreeController::class => InvokableFactory::class,
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'navbar' => function($sm) {
                $app = $sm->getServiceLocator()->get('Application');
                return new NavbarHelper($app);
            },
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];

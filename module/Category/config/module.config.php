<?php 

namespace Category;

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Category\Model\CategoryTableFactory;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\CategoryController::class => ReflectionBasedAbstractFactory::class
        ],
    ],

    'router' => [
        'routes' => [
            'category' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/category[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CategoryController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'category' => __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            Model\CategoryTable::class => CategoryTableFactory::class,
        ],

    ],
];
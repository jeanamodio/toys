<?php 

namespace Toy;

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Toy\Model\ToyTableFactory;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\ToyController::class => ReflectionBasedAbstractFactory::class
        ],
    ],

    'router' => [
        'routes' => [
            'toy' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/toy[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ToyController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'toy' => __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            Model\ToyTable::class => ToyTableFactory::class,
        ],

    ],
];
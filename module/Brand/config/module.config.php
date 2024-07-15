<?php 

namespace Brand;

use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Brand\Model\BrandTableFactory;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\BrandController::class => ReflectionBasedAbstractFactory::class
        ],
    ],

    'router' => [
        'routes' => [
            'brand' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/brand[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\BrandController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'brand' => __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            Model\BrandTable::class => BrandTableFactory::class,
        ],

    ],
];
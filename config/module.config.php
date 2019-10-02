<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2018-04-03 13:40:14
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2018-05-25 11:54:30
 */

namespace ApiBase;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'service_manager' => [
        'factories' => [
            'doctrine.memcached' => new Factory\DoctrineCache(),
        ],
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'paths' => [__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
];

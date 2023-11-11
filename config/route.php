<?php

return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'api/city'
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'api/country'
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'api/direction'
    ],
    [
        'pattern' => 'api/directions/store',
        'route' => 'api/direction/store',
        'verb' => 'POST',
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'api/meal'
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'api/region'
    ],
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => 'api/list'
    ],
];
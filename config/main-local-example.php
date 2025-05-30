<?php

return CMap::mergeArray(
    require(__DIR__ . '/main.php'),
    [
        'name' => '34travel.me',
        'preload' => ['log', 'debug'],
        'modules' => [
            'gii' => [
                'class' => 'system.gii.GiiModule',
                'password' => false,
                'ipFilters' => ['127.0.0.1', '::1'],
                'generatorPaths' => [
                    'bootstrap.gii',
                ],
            ],
        ],
        'components' => [
            'debug' => [
                'class' => 'ext.yii2-debug.Yii2Debug',
                'allowedIPs' => ['127.0.0.1', '::1'],
            ],
            'db' => [
                'connectionString' => 'mysql:host=localhost;dbname=travel_34',
                'username' => 'root',
                'password' => '',
                'schemaCachingDuration' => 300,
                'enableProfiling' => true,
                'enableParamLogging' => true,
            ],
        ],
        'params' => [
            'adminEmail' => 'test@test.com',
        ],
    ]
);

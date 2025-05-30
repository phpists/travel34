<?php

return [
    'basePath' => dirname(__DIR__),
    'name' => '34travel.me',
    'preload' => ['log'],
    'aliases' => [
        'webroot' => dirname(__DIR__) . '/web',
        'vendor' => dirname(__DIR__) . '/vendor',
    ],
    'import' => [
        'application.components.*',
        'application.helpers.*',
        'application.models.*',
        'ext.yiimailer.YiiMailer',
    ],
    'components' => [
        'cache' => [
            'class' => 'system.caching.CFileCache',
        ],
        'db' => [
            'connectionString' => 'mysql:host=localhost;dbname=34travel',
            'username' => 'root',
            'password' => '',
            'tablePrefix' => 'tr_',
            'charset' => 'utf8mb4',
            'emulatePrepare' => true,
            'schemaCachingDuration' => 300,
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ],
        'log' => [
            'class' => 'CLogRouter',
            'routes' => [
                [
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ],
            ],
        ],
    ],
    'params' => require __DIR__ . '/params.php',
    'commandMap' => [
        'migrate' => [
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationTable' => '{{migration}}',
        ],
    ],
];

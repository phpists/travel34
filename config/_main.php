<?php

Yii::setPathOfAlias('bootstrap', dirname(__DIR__) . '/extensions/bootstrap');
Yii::setPathOfAlias('tablesorter', dirname(__DIR__) . '/extensions/bootstrap');

return [
    'timezone' => 'Europe/Vilnius',
    'basePath' => dirname(__DIR__),
    'name' => '34travel.me',
    'preload' => ['log'],
    'import' => [
        'application.components.*',
        'application.helpers.*',
        'application.models.*',
        'ext.yiimailer.YiiMailer',
    ],
    'behaviors' => [
        'runEnd' => [
            'class' => 'application.behaviors.WebApplicationEndBehavior',
        ],
    ],
    'sourceLanguage' => 'en',
    'language' => 'ru',
    'localeDataPath' => dirname(__DIR__) . '/i18n',
    'modules' => [],
    'components' => [
        'clientScript' => [
            'coreScriptPosition' => CClientScript::POS_END,
            'defaultScriptFilePosition' => CClientScript::POS_END,
            'packages' => [
                /*'jquery' => [
                    'basePath' => 'application.assets.jquery',
                    'js' => ['jquery-2.2.4.min.js'],
                ],*/
                'jquery.ui' => [
                    'basePath' => 'application.assets.jquery-ui',
                    'js' => ['jquery-ui.min.js'],
                    'depends' => ['jquery'],
                ],
            ],
        ],
        'user' => [
            'allowAutoLogin' => true,
            'class' => 'WebUser',
        ],
        'urlManager' => [],
        'cookiesHelper' => [
            'class' => 'application.helpers.CookiesHelper',
        ],
        'db' => [
            'tablePrefix' => 'tr_',
            'charset' => 'utf8mb4',
            'emulatePrepare' => true,
            'schemaCachingDuration' => 86400,
        ],
        'errorHandler' => [
            'errorAction' => 'error/index',
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
        'authManager' => [
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ],
        'cache' => [
            'class' => 'system.caching.CFileCache',
        ],
        'geo' => [
            'class' => 'application.components.Geo',
        ],
        /*'messages' => [
            'forceTranslation' => true,
        ],*/
        // Localized Formatter
        'format' => [
            'class' => 'CLocalizedFormatter',
        ],
        'userComponent' => [
            'class' => 'UserComponent',
        ],
        'stripe' => [
            'class' => 'StripeComponent',
            'apiKey' => 'sk_test_51N1StgB5rrrRostLLeFnA7PXKtGCofmSBYa7pW71kQAQ4k72u849tVcMZv3iyUS9el3cK4HOHfsT0YrbyxUnMN9G002qjTUypC',
        ],
        'mailer' => [
            'class' => 'application.extensions.mailer.EMailer',
            'pathViews' => 'application.views.email',
            'pathLayouts' => 'application.views.email.layouts'
        ],
        'smtp' => array(
            'class' => 'application.extensions.mailer.YiiMailer',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.yourserver.com',
                'username' => 'your@email.com',
                'password' => 'your_password',
                'port' => '587',
                'encryption' => 'tls',
            ),
        ),
    ],
    'charset' => 'UTF-8',
    'params' => require __DIR__ . '/params.php',
];

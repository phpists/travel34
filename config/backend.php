<?php

return CMap::mergeArray(
    require(__DIR__ . '/main-' . APPLICATION_ENVIRONMENT . '.php'),
    [
        'language' => 'ru',
        'theme' => 'blackboot',
        'defaultController' => 'admin',
        //'preload' => array('bootstrap'),
        'components' => [
            'clientScript' => [
                'coreScriptPosition' => CClientScript::POS_END,
                'defaultScriptFilePosition' => CClientScript::POS_END,
            ],
            'urlManager' => [
                'urlFormat' => 'path',
                'showScriptName' => false,
                'rules' => [
                    'admin' => 'post/index',
                    'admin/<_a:(login|logout|error|clearCache)>' => 'admin/<_a>',
                    'admin/<_c:\w+>' => '<_c>/index',
                    'admin/<_c:\w+>/<_a:\w+>/<id:\d+>' => '<_c>/<_a>',
                    'admin/<_c:\w+>/<_a:\w+>' => '<_c>/<_a>',
                ],
            ],
            'bootstrap' => [
                'class' => 'ext.bootstrap.components.Bootstrap',
            ],
        ],
    ]
);

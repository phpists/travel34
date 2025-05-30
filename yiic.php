<?php

//$yiic = __DIR__ . '/vendor/yiisoft/yii/framework/yiic.php';
$yii = __DIR__ . '/vendor/yiisoft/yii/framework/yii.php';
$config = __DIR__ . '/config/console.php';

// fix for fcgi
defined('STDIN') or define('STDIN', fopen('php://stdin', 'r'));
defined('YII_DEBUG') or define('YII_DEBUG', true);

require_once($yii);
Yii::setPathOfAlias('vendor', __DIR__ . '/vendor');
$app = Yii::createConsoleApplication($config);
$app->commandRunner->addCommands(YII_PATH . '/cli/commands');
Yii::import('vendor.autoload', true);
$app->run();

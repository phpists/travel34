<?php
ini_set('memory_limit', '512M');
// set utf-8
ini_set('default_charset', 'UTF-8');
if (version_compare(PHP_VERSION, '5.6.0', '<')) {
    mb_internal_encoding('UTF-8');
}
mb_regex_encoding('UTF-8');

$environment = getenv('APPLICATION_ENVIRONMENT');
if (empty($environment)) {
    $environment = 'production';
}



if ($environment == 'local') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
} else {
    define('YII_ENABLE_ERROR_HANDLER', false);
    error_reporting(0);
}

defined('APPLICATION_ENVIRONMENT') or define('APPLICATION_ENVIRONMENT', $environment);

$yii = __DIR__ . '/../vendor/yiisoft/yii/framework/yii.php';
$config = __DIR__ . '/../config/backend.php';

require_once($yii);
Yii::setPathOfAlias('vendor', dirname(__DIR__) . '/vendor');
$app = Yii::createWebApplication($config);
Yii::import('vendor.autoload', true);
$app->runEnd('backend');

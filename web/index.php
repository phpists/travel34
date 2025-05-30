<?php
$environment = getenv('APPLICATION_ENVIRONMENT');
if (empty($environment)) {
    $environment = 'production';
}

if ($environment == 'local') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
} else {
    define('YII_ENABLE_ERROR_HANDLER', false);
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    error_reporting(0);
}

defined('APPLICATION_ENVIRONMENT') or define('APPLICATION_ENVIRONMENT', $environment);

$yii = __DIR__ . '/../vendor/yiisoft/yii/framework/yii.php';
$config = __DIR__ . '/../config/frontend.php';

require_once($yii);
Yii::setPathOfAlias('vendor', dirname(__DIR__) . '/vendor');
$app = Yii::createWebApplication($config);
Yii::import('vendor.autoload', true);
$app->runEnd('frontend');

if (isset($_GET['test'])) {
   echo "new";
}

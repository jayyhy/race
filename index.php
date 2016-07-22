<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

$host = $_SERVER["HTTP_HOST"];
defined('HOST_IP') or define('HOST_IP', $host);

//设置时区
date_default_timezone_set('PRC');



defined('WWW') or define('WWW', 'http://'.$host.'/');
defined('SITE_URL') or define('SITE_URL','http://'.$host.dirname($_SERVER['PHP_SELF']).'/');//网站根目录
//
//前台
defined('CSS_URL') or define('CSS_URL',SITE_URL.'css/default/');
defined('IMG_URL') or define('IMG_URL',SITE_URL.'img/default/');
defined('IMG_UITea_URL') or define('IMG_UITea_URL',SITE_URL.'img/UI_tea/');
defined('IMG_UIStu_URL') or define('IMG_UIStu_URL',SITE_URL.'img/UI_stu/');
defined('JS_URL') or define('JS_URL',SITE_URL.'js/');
defined('EXER_LISTEN_URL') or define('EXER_LISTEN_URL',SITE_URL.'../reborn/resources/');
defined('XC_Confirm') or define('XC_Confirm',SITE_URL.'css/xcConfirm/');

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();
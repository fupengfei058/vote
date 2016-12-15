<?php
$sys_arr = explode(".",$_SERVER['HTTP_HOST']);
if(!empty($sys_arr[3]) && ($sys_arr[3] == 'com' || $sys_arr[3] == 'cn'))
{
    define('ITEMID',intval($sys_arr[0]));
}
else
{
    exit('Interval Error!');
}
unset($sys_arr);
// change the following paths if necessary
$yii=dirname(__FILE__).'/../framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();

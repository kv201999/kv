<?php
@header("content-Type: text/html; charset=utf-8");
error_reporting(0);
if(!defined("ROOT_PATH")) define("ROOT_PATH",dirname(__FILE__).'/../');
define('GLOBAL_PATH',ROOT_PATH.'global/');
if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
	define('IS_WIN',true);
}else{
	define('IS_WIN',false);
}
//db配置
include GLOBAL_PATH.'db.conf.php';

//公共方法
include GLOBAL_PATH.'global.func.php';
include GLOBAL_PATH.'common.func.php';
include GLOBAL_PATH.'user.func.php';
include GLOBAL_PATH.'wx.func.php';
include GLOBAL_PATH.'wb.func.php';

include GLOBAL_PATH.'library/Mysql.class.php';
include GLOBAL_PATH.'library/MyMemcache.class.php';
include GLOBAL_PATH.'library/Wxapi.class.php';
?>
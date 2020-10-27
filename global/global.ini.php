<?php
@header("content-Type: text/html; charset=utf-8");
if(!defined("APP_DEBUG")) define('APP_DEBUG',false);
if(!defined("ROOT_PATH")) define("ROOT_PATH",dirname(__FILE__).'/../');
define('GLOBAL_PATH',ROOT_PATH.'global/');
define('APP_PATH',ROOT_PATH.APP_NAME.'/');
define('APP_URL',trim($_SERVER['SCRIPT_NAME'],'/'));
define('SYS_KEY','Signsduihfnsk&5sdHwifjpWF@#TUIsfzl');
define('NOW_TIME',time());
define('NOW_DATE',date('Y-m-d H:i:s',NOW_TIME));
if(APP_DEBUG){
	error_reporting(E_ALL & ~E_NOTICE);
}else{
	error_reporting(0);
}

if(strtoupper(substr(PHP_OS,0,3))==='WIN'){
	define('IS_WIN',true);
}else{
	define('IS_WIN',false);
}
if(!$_SERVER['REQUEST_SCHEME']){
	$_SERVER['REQUEST_SCHEME']='http';
}

//db配置
include GLOBAL_PATH.'db.conf.php';

//基本类库
include GLOBAL_PATH.'library/Mysql.class.php';
include GLOBAL_PATH.'library/MyMemcache.class.php';
include GLOBAL_PATH.'library/MyRedis.class.php';
include GLOBAL_PATH.'library/Wxapi.class.php';
include GLOBAL_PATH.'library/Image.class.php';
include GLOBAL_PATH.'library/UploadFile.class.php';
include GLOBAL_PATH.'library/QRcode.class.php';
//include GLOBAL_PATH.'library/Passport.class.php';
//include GLOBAL_PATH.'library/Session.class.php';

//公共方法
include GLOBAL_PATH.'global.func.php';
include GLOBAL_PATH.'common.func.php';
include GLOBAL_PATH.'user.func.php';
include GLOBAL_PATH.'wx.func.php';
//include GLOBAL_PATH.'wb.func.php';

define('CLIENT_IP',get_client_ip());

$wx_gzh_config=getConfig('wx_gzh_config');
if(!defined("APP_ID")) define('APP_ID',$wx_gzh_config['appid']);

//项目配置
include APP_PATH.'/common/app.conf.php';

?>
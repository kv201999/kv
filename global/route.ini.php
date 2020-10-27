<?php
//自动加载模型
function __autoload($class_name) { 
	if(strpos('Model',$class_name)===false){
		
	}else{
		//自动加载对应项目模型
		$path_arr=array(
			'model/'
		);
		$has_model_file=false;
		foreach($path_arr as $val){
			$path=APP_PATH.$val.'/'.$class_name.'.class.php';
			if(file_exists($path)){
				$has_model_file=true;
				require_once $path;
				break;
			}
		}
		if(!$has_model_file){
			doExit("no such file: model/{$class_name}.class.php");
		}
		if(!class_exists($class_name)){
			doExit("no such class {$class_name}");
		}
	}
}

//普通路由
$params=getParam();
$params['c']=ucfirst(strtolower($params['c']));
if(!$params['c']){
	$params['c']='Default';
}
if(!$params['a']){
	$params['a']='index';
}

$controller=$params['c'];
$action=$params['a'];
define('CONTROLLER_NAME',$controller);
define('ACTION_NAME',$action);
define('NKEY',CONTROLLER_NAME.'_'.ACTION_NAME);
$controller=$controller.'Controller';
$action='_'.$action;

//检查文件是否存在/检查类是否存在/检查类是否存在对应的方法
$ctrl_file=APP_PATH.'controller/'.$controller.'.class.php';
if(!file_exists($ctrl_file)){
	doExit("no such ctrl file:{$ctrl_file}");
}

require_once(APP_PATH.'controller/BaseController.class.php');
require_once($ctrl_file);

if(!class_exists($controller)){
	doExit("no such class:{$controller}");
}
$controller_obj=new $controller();
if(!$controller_obj){
	doExit("new {$controller} fail");
}
if(!method_exists($controller_obj,$action)){
	doExit("no such {$action}");
}

$controller_obj->$action();

?>
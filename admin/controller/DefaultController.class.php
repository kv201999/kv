<?php
!defined('ROOT_PATH') && exit;
class DefaultController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	//后台框架首页
	public function _index(){
		$pageuser=checkPower();
		if($pageuser['gid']>=91){
			exit('抱歉，没有权限访问');
		}
		$mysql_version=$this->mysql->fetchResult("select version()");
		
		$menu=getUserMenu($pageuser['id'],$this->mysql);
		$data=array(
			'user'=>$pageuser,
			'menu_json'=>json_encode(array_values($menu)),
			'sys_group'=>getConfig('sys_group'),
			'mysql_version'=>$mysql_version
		);
		display('Default/index.html',$data);
	}

	//默认内容界面
	public function _default(){
		$pageuser=checkLogin();
		$data=[
			'user'=>$pageuser
		];
		display('Default/default.html',$data);
	}
	
	public function _tj(){
		checkPower();
		$data=[
			'tj'=>getConfig('cnf_default_tj')
		];
		display('Default/tj.html',$data);
	}
	
}
?>
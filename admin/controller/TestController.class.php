<?php
!defined('ROOT_PATH') && exit;
class TestController extends BaseController{
	
	public function __construct(){
		parent::__construct();
		error_reporting(7);
    }

	public function _index(){
		//echo 'hello world!';
		exit;
		$csn='C201910271443534330';
		$osn='H2019102620004791880';
		$url="{$_ENV['SOCKET']['HTTP_URL']}/?c=Admin&a=noticeCash&csn={$csn}";
		$url="{$_ENV['SOCKET']['HTTP_URL']}/?c=Admin&a=noticePay&osn={$osn}";
		$result=curl_get($url);
		$resultArr=json_decode($result['output'],true);
		p($resultArr);
	}
	
	public function _return_url(){
		p($this->params);
	}
	
	public function _notify_url(){
		echo 'success';
	}
    
}

?>
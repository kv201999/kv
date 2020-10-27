<?php
!defined('ROOT_PATH') && exit;
if(!defined("APP_ID")) define('APP_ID',$wx_gzh_config['appid']);
class JssdkController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function _sign(){
		$jssdk_ticket=getJssdkTicket();
		if(!$jssdk_ticket){
			$data=array('jsapi_ticket'=>'','noncestr'=>'','timestamp'=>'','signature'=>'');
			jReturn('-1','獲取jssdk_ticket失敗',$data);
		}
		$data=array(
			'jsapi_ticket'=>$jssdk_ticket,
			'noncestr'=>'noncestr_'.mt_rand(111111,999999),
			'timestamp'=>NOW_TIME,
			'url'=>urldecode($_REQUEST['url'])
		);
		ksort($data);
		$str='';
		foreach($data as $key=>$val){
				$str.="{$key}={$val}&";
		}
		$str=trim($str,'&');
		$data['signature']=sha1($str);
		$data['appid']=APP_ID;
		unset($data['jsapi_ticket']);
		jReturn('1','ok',$data);
	}
	
}

?>
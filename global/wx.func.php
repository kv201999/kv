<?php
/*微信接口方法*/

//获取微信接口统一对象
function getWxapiObj($appid=APP_ID){
	$wxapiObj=new Wxapi($appid);
	return $wxapiObj;
}

//前往验证地址获取
function wxAuthUrl($redirect_uri,$auth_type='base',$redirect_state='0'){
	if($auth_type=='base'){
		$api_url_str='https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect';
	}else{
		$api_url_str='https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=%s#wechat_redirect';
	}
	$api_url=sprintf($api_url_str,APP_ID,urlencode($redirect_uri),$redirect_state);
	return $api_url;
}

//获取微信用户信息
function getWxUser($code,$oauth=''){
	$wxapiObj=getWxapiObj();
	$wx_user=$wxapiObj->getUserInfo2($code,$oauth);
	unset($wxapiObj);
	return $wx_user;
}

/////////////////////////摇一摇相关开始//////////////////////////////
//获取摇一摇用户相关信息
function getShakeInfo(){
	$ticket=getParam('ticket');
	if(!$ticket){
		return false;
	}
	$wxapiObj=getWxapiObj();
	$data=$wxapiObj->getShakeInfo($ticket);
	unset($wxapiObj);
	return $data;
}

//查询所有分组
function shakeGroupList(){
	$access_token=getToken();
	$api_url="https://api.weixin.qq.com/shakearound/device/group/getlist?access_token={$access_token}";
	$data=json_encode(array('begin'=>0,'count'=>100));
	$result=curl_post($api_url,$data);
	p(json_decode($result['output'],'1'));
}

//创建设备分组
function shakeGroupAdd(){
	$access_token=getToken();
	$api_url="https://api.weixin.qq.com/shakearound/device/group/add?access_token={$access_token}";
	$data=json_encode(array('group_name'=>'test'));
	$result=curl_post($api_url,$data);
	p(json_decode($result['output'],'1'));//test 834089
}

//查询分组详情
function shakeGroupInfo($group_id){
	$access_token=getToken();
	$api_url="https://api.weixin.qq.com/shakearound/device/group/getdetail?access_token={$access_token}";
	$data=json_encode(array('group_id'=>$group_id,'begin'=>0,'count'=>100));
	$result=curl_post($api_url,$data);
	p(json_decode($result['output'],'1'));
}

//将设备添加到分组
function shakeDeviceToGroup(){
	$access_token=getToken();
	$api_url="https://api.weixin.qq.com/shakearound/device/group/adddevice?access_token={$access_token}";
	$data=array(
		'group_id'=>834089,
		'device_identifiers'=>array(
			array('device_id'=>4970152)
		)
	);
	$data_str=json_encode($data);
	$result=curl_post($api_url,$data_str);
	p(json_decode($result['output'],'1'));
}


/////////////////////////基础方法//////////////////////////////
//获取token
function getToken(){
	$wxapiObj=getWxapiObj();
	$access_token=$wxapiObj->getToken();
	unset($wxapiObj);
	return $access_token;
}

//获取jssdk-ticket
function getJssdkTicket(){
	$wxapiObj=getWxapiObj();
	$ticket=$wxapiObj->getJssdkTicket();
	unset($wxapiObj);
	return $ticket;
}

//获取菜单
function getMenu(){
	$wxapiObj=getWxapiObj();
	$data=$wxapiObj->getMenu();
	unset($wxapiObj);
	return $data;
}

//下载微信图片
function downloadImage($media_id){
	$access_token=getToken();
	$api_url='https://api.weixin.qq.com/cgi-bin/material/get_material?access_token='.$access_token;
	$data=array('media_id'=>$media_id);
	$data_json=json_encode($data);
	$result=curl_post($api_url,$data_json);
	return json_decode($result['output'],1);
}

//生成二维码
function getQrcode($scene_id='',$type='tmp'){
	$wxapiObj=getWxapiObj();
	$qrcode_url=$wxapiObj->getQrcode($scene_id,$type);
	unset($wxapiObj);
	return $qrcode_url;
}

//发红包
function sendHongbao($openid,$money,$act_name='',$sub_mch_id=0){
	$wxapiObj=getWxapiObj();
	$result=$wxapiObj->sendHongbao($openid,$money,$act_name,$sub_mch_id);
	unset($wxapiObj);
	return $result;
}

//预支付下单 如果交易类型是jsapi则返回值自动包含交易签名
function prepayOrder($openid,$money,$notify_url,$trade_type='JSAPI',$sub_mch_id=0){
	$wxapiObj=getWxapiObj();
	$result=$wxapiObj->prepayOrder($openid,$money,$notify_url,$trade_type,$sub_mch_id);
	unset($wxapiObj);
	return $result;
}

//获取jsapi支付签名(此方法在JSAPI支付类型时已经被包含在预付下单中)
function getPaySign($prepay_id){
	$wxapiObj=getWxapiObj();
	$result=$wxapiObj->getPaySign($prepay_id);
	unset($wxapiObj);
	return $result;
}



///////////////////////////常用消息方法/////////////////////////////////
function sendTxtMsg($fromUser,$toUser,$msg){
	$create_time=NOW_TIME;
	$tpl="<xml>
	<ToUserName><![CDATA[{$toUser}]]></ToUserName>
	<FromUserName><![CDATA[{$fromUser}]]></FromUserName>
	<CreateTime>{$create_time}</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[{$msg}]]></Content>
	</xml>";
	exit($tpl);
}

function sendImgMsg($fromUser,$toUser,$media_id='',$file='',$file_mine=''){
	if(!$media_id&&!$file){
		return false;
	}
	if(!$media_id){
		$media_id=wxUploadFile($file,'image',$file_mine);
		if(!$media_id){
			return false;
		}
	}
	$create_time=NOW_TIME;
	$tpl="<xml><ToUserName><![CDATA[{$toUser}]]></ToUserName><FromUserName><![CDATA[{$fromUser}]]></FromUserName><CreateTime>{$create_time}</CreateTime><MsgType><![CDATA[image]]></MsgType><Image><MediaId><![CDATA[{$media_id}]]></MediaId></Image></xml>";
	exit($tpl);
}


function sendVoiceMsg($fromUser,$toUser,$media_id='',$file='',$file_mine=''){
	if(!$media_id&&!$file){
		return false;
	}
	if(!$media_id){
		$media_id=wxUploadFile($file,'voice',$file_mine);
		if(!$media_id){
			return false;
		}
	}
	$create_time=NOW_TIME;
	$tpl="<xml><ToUserName><![CDATA[{$toUser}]]></ToUserName><FromUserName><![CDATA[{$fromUser}]]></FromUserName><CreateTime>{$create_time}</CreateTime><MsgType><![CDATA[voice]]></MsgType><Voice><MediaId><![CDATA[{$media_id}]]></MediaId></Voice></xml>";
	exit($tpl);
}

function sendVideoMsg($fromUser,$toUser,$media_id='',$file='',$file_mine='',$title,$description){
	if(!$media_id&&!$file){
		return false;
	}
	if(!$media_id){
		$media_id=wxUploadFile($file,'video',$file_mine);
		if(!$media_id){
			return false;
		}
	}
	$create_time=NOW_TIME;
	$tpl="<xml><ToUserName><![CDATA[{$toUser}]]></ToUserName><FromUserName><![CDATA[{$fromUser}]]></FromUserName><CreateTime>{$create_time}</CreateTime><MsgType><![CDATA[video] ]></MsgType><Video><MediaId><![CDATA[{$media_id}]]></MediaId><Title><![CDATA[{$title}]]></Title><Description><![CDATA[{$description}]]></Description></Video></xml>";
	exit($tpl);
}

function sendNewsMsg($fromUser,$toUser,$arclist){
	$create_time=NOW_TIME;
	$count=count($arclist);
	$tpl="<xml>
		<ToUserName><![CDATA[{$toUser}]]></ToUserName>
		<FromUserName><![CDATA[{$fromUser}]]></FromUserName>
		<CreateTime>{$create_time}</CreateTime>
		<MsgType><![CDATA[news]]></MsgType>
		<ArticleCount>{$count}</ArticleCount>
		<Articles>";
		foreach($arclist as $arc){
			$tpl.="<item>
				<Title><![CDATA[{$arc['title']}]]></Title>
				<Description><![CDATA[{$arc['description']}]]></Description>
				<PicUrl><![CDATA[{$arc['picurl']}]]></PicUrl>
				<Url><![CDATA[{$arc['url']}]]></Url>
			</item>";	
		}
	$tpl.="</Articles></xml>";
	exit($tpl);
}


function wxUploadFile($file_realpath,$type,$mine_type=''){
	$arrow_type=array('image','voice','video','thumb');
	if(!in_array($type,$arrow_type)){
		return false;
	}
	if(version_compare(PHP_VERSION,'5.6.0','ge')){
		$media_data=array("media"=>new \CURLFile($file_realpath,$mine_type));
	}else{
		$media_data=array('media'=>'@'.$file_realpath);
	}
	if(!$media_data){
		return false;
	}
	$token=getToken();
	$api="https://api.weixin.qq.com/cgi-bin/media/upload?access_token={$token}&type={$type}";
	$result=curl_post($api,$media_data);
	$resultArr=json_decode($result['output'],true);
	if(!$resultArr['media_id']){
		return false;
	}
	return $resultArr['media_id'];
}

//模板消息
function sendTplMsg($openid,$template_id,$tpldata,$url='',$appid='',$pagepath=''){
	$params=array(
		'touser'=>$openid,
		'template_id'=>$template_id,
		'url'=>$url,
		'miniprogram'=>array(
			'appid'=>$appid,
			'pagepath'=>$pagepath
		),
		'data'=>$tpldata
	);
	$params_json=json_encode($params);
	$token=getToken();
	$api_url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$token}";
	$result=curl_post($api_url,$params_json);
	return json_decode($result['output'],true);
}

//下载获取文件内容
function curl_file($url){
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 0);//只取body头
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}  

?>
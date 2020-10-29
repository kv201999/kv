<?php
include './conf.php';

$now_time=time();
$p_data=array(
	'time'=>$now_time,
	'mch_id'=>'shanghu',
	'out_order_sn'=>'SH20201021181035'
);
ksort($p_data);
$sign_str='';
foreach($p_data as $pk=>$pv){
	$sign_str.="{$pk}={$pv}&";
}
$sign_str.="key={$mch_key}";
$p_data['sign']=md5($sign_str);



//
////######################rsa加密########################
////如果平台未开启RSA加密传输可忽略此段
//$json_str=base64_encode(json_encode($p_data,256));
//$resultArr=encryptRsa($json_str,$pt_rsa_public)
//if($resultArr['code']!='1'){
//	exit($resultArr['msg']);
//}
////rsa加密只需要传加密后的数据，参数名称是 crypted
//$p_data=[
//	'crypted'=>$resultArr['data']
//];
////如果平台未开启RSA加密传输可忽略此段
////######################rsa加密########################

$url='http://127.0.0.1/?c=Pay&a=query&';
$url.=http_build_query($p_data);
header("Location:{$url}");

?>
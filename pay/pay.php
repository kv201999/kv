<?php
include './conf.php';

$params=$_REQUEST;
$ptype=intval($params['ptype']);//支付类型
if(!$ptype){
	$ptype=3;
}
$money=floatval($params['money']);
$usdtaddress=$params['usdtaddress'];
if(!$money||$money<0.01){
	$money=mt_rand(10,100)/100;
}
$now_time=time();
$p_data=array(
	'time'=>$now_time,
	'mch_id'=>$mch_id,
	'ptype'=>$ptype,
	'order_sn'=>'SH'.date('YmdHis',$now_time),
	'money'=>$money,
	'goods_desc'=>'buy',
	'client_ip'=>'127.0.0.1',
	'format'=>'page',
	'notify_url'=>'http://127.0.0.1/api/notify.php'
);
ksort($p_data);
$sign_str='';
foreach($p_data as $pk=>$pv){
	$sign_str.="{$pk}={$pv}&";
}
$sign_str.="key={$mch_key}";
$p_data['sign']=md5($sign_str);

////######################rsa加密########################
////如果平台未开启RSA加密传输可忽略此段
//$json_str=base64_encode(json_encode($p_data,256));
//$resultArr=encryptRsa($json_str,$pt_rsa_public);
//if($resultArr['code']!='1'){
//	exit($resultArr['msg']);
//}
////rsa加密只需要传加密后的数据，参数名称是 crypted
//$p_data=[
//	'crypted'=>($resultArr['data'])
//];
////如果平台未开启RSA加密传输可忽略此段
////######################rsa加密########################

$url='http://127.0.0.1/?c=Pay&';
$url.=http_build_query($p_data);
header("Location:{$url}");

?>
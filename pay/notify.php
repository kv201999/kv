<?php

include './conf.php';
$params=$_REQUEST;

////######################rsa解密########################
////如果平台未开启RSA加密传输可忽略此段
//$crypted=implode('+',explode(' ',$params['crypted']));
//$resultArr=decryptRsa($crypted,$mch_rsa_private);
//if($resultArr['code']!='1'){
//	exit($resultArr['msg']);
//}
//$params=$resultArr['data'];
////如果平台未开启RSA加密传输可忽略此段
////######################rsa解密########################
$mch_key='b534c98ca47d74c5cf44145e3733ec099a6683c9';
$now_time=time();
$pdata=[
	'pt_order'=>'MS2020102216114027440',
	'sh_order'=>'SH20201022161140',
	'money'=>'0.31',
	'status'=>'success',
	'time'=>$now_time
];
ksort($pdata);
$str='';
foreach($pdata as $pk=>$pv){
	$str.="{$pk}={$pv}&";
}
$str.="key={$mch_key}";
$pdata['sign']=md5($str);


//if($sign==$params['sign']){
//	if($pdata['status']=='success'){
//		//处理具体业务
//
//		echo 'success';
//	}else{
//		echo 'fail';
//	}
//}else{
//	echo 'sing error';
//}



$url='http://127.0.0.1/?c=Notify&mid=1649&';
$url.=http_build_query($pdata);
header("Location:{$url}");
?>
<?php
/*项目方法*/

function parseMoney($data){
	$money=0;
	$phone=trim(trim($data['title']),'+');
	$tpl=str_replace(',','',$data['content']);
	if(!$phone||!$tpl){
		return $money;
	}
	$white_arr=['106927995511','106980096511'];
	if(!in_array($phone,$white_arr)){
		$reg='/^(95|96)[0-9]{3,}$/';
		if(!preg_match($reg,$phone)&&strpos($phone,'银行')===false&&strpos($phone,'邮政')===false){
			return $money;
		}	
	}

	if(strpos($tpl,'验证码')!==false){
		return $money;
	}
	
	$reg='/(\d{1,}(\.\d+)?)/is';
	preg_match_all($reg,$tpl,$resultArr);
	$number_arr=[];
	foreach($resultArr[0] as $rv){
		if(is_numeric($rv)){
			$number_arr[]=floatval($rv);
		}
	}
	if($phone=='招商银行'||strpos($tpl,'更多详情请查看招商银行APP动账通知')!==false){
		$money=$number_arr[count($number_arr)-1];
	}elseif($phone=='光大银行'){
		if(strpos($tpl,'尊敬的客户')!==false){
			$money=$number_arr[count($number_arr)-4];
		}else{
			$money=$number_arr[count($number_arr)-2];
		}
	}else{
		if(count($number_arr)<2){
			return $money;
		}
		$money=$number_arr[count($number_arr)-2];
	}
	return $money;
}

function parseUri($tpl){
	$uri_arr=explode('&',trim(trim($tpl),'&'));
	$tp_data=[];
	foreach($uri_arr as $val){
		$val_arr=explode('=',$val);
		$tp_data[trim($val_arr[0])]=trim($val_arr[1]);
	}
	return $tp_data;
}

?>
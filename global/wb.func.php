<?php
//跳转发起
function jumpWbhb($money,$sk_ma,$mysql=null){
	if(!$sk_ma||!$money||$money<0.01){
		return ['code'=>'-1','msg'=>'缺少参数'];
	}
	$need_close=false;
	if(!$mysql){
		$mysql=new Mysql(0);
		$need_close=true;
	}
	//轮询账号
	$wb_account=$mysql->fetchRow("select * from sk_ma_account where ma_id={$sk_ma['id']} and status=1 order by rand()");
	if($need_close){
		$mysql->close();
		unset($mysql);
	}
	$count=ceil($money/200);
	$result=wbstep1($money,$count,$wb_account);
	//file_put_contents(ROOT_PATH.'logs/wb.txt',var_export($result,true)."\n\n",FILE_APPEND);
	if($result['code']!=1){
		return $result;
	}
	$pattern="/<input(.*?)name=\"biz_content\"(.*?)value=\"(.*?)\"\/>/i";
	preg_match($pattern,$result['html'],$matches);
	$json=htmlspecialchars_decode($matches[3]);
	$biz_content=json_decode($json,true);
	$outrade_no=$biz_content['out_trade_no'];
	if(!$outrade_no){
		file_put_contents(ROOT_PATH.'logs/wb.txt',$result['html']."\n\n",FILE_APPEND);
		return ['code'=>'-1','msg'=>'out_trade_no参数匹配失败'];
	}
	$url_arr=parse_url($result['url']);
	$url_arr2=explode('&',$url_arr['query']);
	$outpay_id='';
	foreach($url_arr2 as $av){
		$av_arr=explode('=',$av);
		if($av_arr[0]=='out_pay_id'){
			$outpay_id=trim($av_arr[1]);
			break;
		}
	}
	return [
		'code'=>'1',
		'outpay_id'=>$outpay_id,
		'outrade_no'=>$outrade_no,
		'wb_uid'=>$wb_account['wb_uid'],
		'html'=>$result['html']
	];
}

//查询判断订单是否成功
function checkWbhbByOrder($order,$mysql=null){
	if(!$order||!$order['wb_uid']||!$order['outrade_no']){
		return ['code'=>'-1','msg'=>'缺少参数,检查登录状态'];
	}
	$need_close=false;
	if(!$mysql){
		$mysql=new Mysql(0);
		$need_close=true;
	}
	$wb_account=$mysql->fetchRow("select * from sk_ma_account where wb_uid={$order['wb_uid']}");
	if($need_close){
		$mysql->close();
		unset($mysql);
	}
	if(!$wb_account){
		return ['code'=>'-1','msg'=>'缺少账号信息'];
	}
	$status=2;
	$page=1;
	$result=getWbhbListByPage($order['outrade_no'],$status,$wb_account,$page);
	if($result['code']!=1){
		return $result;
	}
	$data=$result['data'];
	$biz=$data['biz'][0];
	if(!$biz){
		return [
			'code'=>'-1',
			'msg'=>'订单待支付',
			'data'=>$data,
			'order_sn'=>$order['order_sn'],
			'wb_uid'=>$order['wb_uid'],
			'money'=>$order['money']
		];
	}
	if($biz['status']==2){
		return ['code'=>'1','msg'=>$biz['status_desc']];
	}
	return ['code'=>'-1','msg'=>$biz['status_desc']];
}

//发消息
function sendWbMsg($order,$mysql){
	if(!$order||!$order['wb_uid']||!$order['outrade_no']){
		return ['code'=>'-1','msg'=>'缺少参数,检查登录状态'];
	}
	$count=ceil($order['money']/200);
	$wb_uid=$order['wb_uid'];
	$to_account_arr=$mysql->fetchRows("select * from sk_ma_account where ma_id={$order['ma_id']} and wb_uid!={$wb_uid} and status=1 and can_get=1 order by rand()",1,$count);
	if(count($to_account_arr)<$count){
		return ['code'=>'-1','msg'=>'领取账号不足'];
	}
	$wb_account=$mysql->fetchRow("select * from sk_ma_account where wb_uid={$wb_uid}");
	$send_result=true;
	foreach($to_account_arr as $to_account){
		$result=sendWbMsgAct($order['outpay_id'],$to_account['wb_uid'],$wb_account);
		if($result['code']!=1){
			$send_result=false;
			break;
		}
		sleep(mt_rand(1,2));
	}
	if(!$send_result){
		//标记不能再发起
		$mysql->update(['can_send'=>0],"wb_uid={$wb_account['wb_uid']}",'sk_ma_account');
		return $result;
	}
	sleep(mt_rand(1,3));

	$wb_finish=1;
	$error_arr=[];
	foreach($to_account_arr as $to_account){
		$result2=openWbhb($order['outpay_id'],$to_account);
		if($result2['code']==1){
			$data=$result2['data'];
			$sk_ma_account_log=[
				'order_id'=>$order['id'],
				'wb_uid'=>$data['wb_uid'],
				'outpay_id'=>$data['outpay_id'],
				'money'=>$data['money'],
				'create_time'=>time()
			];
			$mysql->insert($sk_ma_account_log,'sk_ma_account_log');
			//echo $mysql->lastSql;
		}else{
			$wb_finish=0;
			$error_arr[$to_account['wb_uid']]=$result2;
			//标记不能再接收
			$mysql->update(['can_get'=>0],"wb_uid={$to_account['wb_uid']}",'sk_ma_account');
		}
		sleep(mt_rand(1,2));
	}
	
	return [
		'code'=>1,
		'msg'=>'领取完成',
		'wb_finish'=>$wb_finish,
		'error_arr'=>$error_arr
	];
}

//获取单个账号时间段内的所有订单
function getWbhbListByAccount($wb_account,$outrade_no=0,$status=0,$page=1,$biz_data=[]){
	$result=getWbhbListByPage($outrade_no,$status,$wb_account,$page);
	if($result['code']!=1){
		return $biz_data;
	}
	$data=$result['data'];
	foreach($data['biz'] as $biz){
		$biz_data[]=$biz;
	}
	if($data['has_next_page']){
		sleep(mt_rand(1,3));
		$tmp_biz_data=getWbhbListByAccount($wb_account,$outrade_no,$status,$data['page']+1,[]);
		$biz_data=array_merge_recursive($biz_data,$tmp_biz_data);
	}
	return $biz_data;
}

?>
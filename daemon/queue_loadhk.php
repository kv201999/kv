<?php
include 'daemon.ini.php';

while(true){
	if(!$mysql){
		$mysql=new Mysql(0);
    }
	$sql="select * from sk_order_hkcsv where is_load=0";
    $list=$mysql->fetchRows($sql,1,1);
	//p($list);exit;
    //echo $mysql->lastSql;exit;
    if(!$list){
        echo "没有数据暂停5秒\n";
		$mysql->close();
		unset($mysql);
        sleep(5);
        continue;
    }
    foreach($list as $item){
		$sk_order_hkcsv=[
			'is_load'=>1,
			'load_time'=>time()
		];
		$res=$mysql->update($sk_order_hkcsv,"id={$item['id']}",'sk_order_hkcsv');
		if(!$res){
			continue;
		}
		$file=ROOT_PATH.$item['csv'];
		if(!file_exists($file)){
			echo "不存在相应的文件{$file}\n\n";
			continue;
		}
		$csv_data=readCsv($file,true);
		$cdata=$csv_data['data_index'];
		if(!$cdata){
			continue;
		}
		foreach($cdata as $ck=>$cv){
			$order_id=intval($cv[0]);
			$money=floatval($cv[1]);
			if(!$order_id||$money<0.01){
				continue;
			}
			$result=agenthkCheck($order_id,$money,$item['create_gid'],$item['create_id'],$mysql);
			if($result!==true){
				if($result===false){
					$mysql->rollback();
				}
				file_put_contents(ROOT_PATH.'logs/orderhk.txt',$result."\n".var_export($cv,true)."\n\n",FILE_APPEND);
			}
			if($ck&&$ck%10==0){
				sleep(1);
				echo "处理完10个订单，暂停1秒\n";
			}
		}
    }
	$mysql->close();
    unset($mysql);
    echo "处理完一批，暂停3秒\n";
    sleep(3);
}



//确认回款
function agenthkCheck($order_id,$money,$c_gid,$c_uid,$mysql){
	$mysql->startTrans();
	$item=$mysql->fetchRow("select * from sk_agent_hklog where oid={$order_id} and status<3 for update");
	if(!$item){
		return '不存在相应记录';
	}
	if($item['aid']){
		if($item['aid']!=$c_uid){
			return '您没有权限审核该记录';
		}
	}else{
		if($c_gid>41){
			return '您没有权限审核该记录';
		}
	}
	if($money!=$item['money']){
		return '与订单应回款金额不一致';
	}
	$status=3;
	$sk_agent_hklog=[
		'status'=>$status,
		'check_time'=>time(),
		'check_id'=>$c_uid
	];
	$res=$mysql->update($sk_agent_hklog,"id={$item['id']}",'sk_agent_hklog');
	if($item['aid']){
		//增加审核者应回款
		$user=$mysql->fetchRow("select * from sys_user where id={$item['aid']} for update");
		$sys_user=[
			'kb_balance'=>$user['kb_balance']+$item['money']
		];
		$res2=$mysql->update($sys_user,"id={$user['id']}",'sys_user');
		$res3=balanceLog($user,4,24,$item['money'],$item['oid'],$item['osn'],$mysql);
	}else{
		$res2=true;
		$res3=true;
	}
	//需要恢复码商接单余额
	if($item['need_recover']){
		$user2=$mysql->fetchRow("select * from sys_user where id={$item['uid']} for update");
		$sys_user2=[
			'sx_balance'=>$user2['sx_balance']+$item['money']
		];
		$res4=$mysql->update($sys_user2,"id={$user2['id']}",'sys_user');
		$res5=balanceLog($user2,3,20,$item['money'],$item['id'],'审核回款记录恢复接单余额',$mysql);
	}else{
		$res4=true;
		$res5=true;
	}
	//单个订单提交的回款需要更新订单记录的回款状态
	if($item['oid']){
		$sk_order=[
			'hk_status'=>3
		];
		$res6=$mysql->update($sk_order,"id={$item['oid']}",'sk_order');
	}else{
		$res6=true;
	}
	if($res===false||!$res2||!$res3||!$res4||!$res5||!$res6){
		$mysql->rollback();
		return false;
	}
	$mysql->commit();
	return true;
}

?>
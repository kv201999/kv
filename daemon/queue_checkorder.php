<?php
include 'daemon.ini.php';

while(true){
	if(!$mysql){
		$mysql=new Mysql(0);
    }
	$skorder_over_time=intval(getConfig('skorder_over_time'));
	if($skorder_over_time<=0){
		$skorder_over_time=60*15;
	}
	$diff_time=time()-$skorder_over_time;
	
	$skorder_over_time2=intval(getConfig('skorder_over_time2'));
	if($skorder_over_time2<=0){
		$skorder_over_time2=60*15;
	}
	$diff_time2=time()-$skorder_over_time2;
	
	$sql="select * from sk_order where (pay_status=1 and create_time<{$diff_time}) or (pay_status=2 and create_time<{$diff_time2})";
    $list=$mysql->fetchRows($sql,1,5);
	//p($list);exit;
    //echo $mysql->lastSql;exit;
    if(!$list){
        echo "没有数据暂停5秒\n";
		$mysql->close();
		unset($mysql);
        sleep(5);
        continue;
    }
	//超时订单，退还冻结金额
    foreach($list as $item){
		$mysql->startTrans();
		$user=$mysql->fetchRow("select id,sx_balance,fz_balance from sys_user where id={$item['muid']} for update");
		$sys_user=[
			'sx_balance'=>$user['sx_balance']+$item['money'],
			'fz_balance'=>$user['fz_balance']-$item['money']
		];
		$res2=$mysql->update($sys_user,"id={$user['id']}",'sys_user');
		$res3=balanceLog($user,3,15,$item['money'],$item['id'],$item['order_sn'],$mysql);
		$res4=balanceLog($user,2,15,-$item['money'],$item['id'],$item['order_sn'],$mysql);
		$sk_order=[
			'pay_status'=>3,
			'over_time'=>time()
		];
		$res=$mysql->update($sk_order,"id={$item['id']}",'sk_order');
		if($res===false||$res2===false||$res3===false||$res4===false){
			$mysql->rollback();
			continue;
		}
		$mysql->commit();
		
		if($item['ma_id']){
			//检测超时的码，如果连续N次都超时，则冻结该码
			$cnf_overtime_mdnum=intval(getConfig('cnf_overtime_mdnum'));
			$over_time_arr=$mysql->fetchRows("select * from sk_order where ma_id={$item['ma_id']} order by id desc",1,$cnf_overtime_mdnum);
			$over_time_cnt=0;
			foreach($over_time_arr as $ov){
				if($ov['pay_status']==3){
					$over_time_cnt++;
				}
			}
			
			if($over_time_cnt>=$cnf_overtime_mdnum){
				$sk_ma=[
					'status'=>1,
					'fz_time'=>time()+90*86400
				];
				$mysql->update($sk_ma,"id={$item['ma_id']}",'sk_ma');
			}
		}
		
    }
	
	$mysql->close();
    unset($mysql);
    echo "处理完一批，暂停1秒\n";
    sleep(1);
}
?>
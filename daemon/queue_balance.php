<?php
include 'daemon.ini.php';

$cnf_xyhk_model=getConfig('cnf_xyhk_model');
$cnf_mshk_signle=getConfig('cnf_mshk_signle');

while(true){
	if(!$mysql){
		$mysql=new Mysql(0);
    }
    $list=$mysql->fetchRows("select * from sk_order where pay_status=9 and js_status=1",1,5);
	//p($list);exit;
    //echo $mysql->lastSql;exit;
    if(!$list){
        echo time()."没有数据暂停5秒\n";
		$mysql->close();
		unset($mysql);
        sleep(5);
        continue;
    }
	//先结算商户订单，再结算分成
    foreach($list as $item){
		$mysql->startTrans();
		$item=$mysql->fetchRow("select * from sk_order where id={$item['id']} for update");
		$user=$mysql->fetchRow("select * from sys_user where id={$item['suid']} for update");
        $blog_id=$mysql->fetchRow("select * from cnf_banklog where uid={$item['suid']} for update");
		$sk_order=[
			'js_status'=>2,
			'js_time'=>time()
		];
		$sys_user=[
			'balance'=>$user['balance']+$item['real_money']
		];
		$res=$mysql->update($sk_order,"id={$item['id']}",'sk_order');
		$res2=$mysql->update($sys_user,"id={$user['id']}",'sys_user');
		$res3=balanceLog($user,1,3,$item['real_money'],$item['id'],$item['order_sn'],$mysql);
		if($res===false||$res2===false||$res3===false){
			$mysql->rollback();
			continue;
		}
		$mysql->commit();
		
		//结算分成
		orderRebate($item['id']);
        //触发自动提现
        if($user['balance']+$item['real_money'] >=4000){
            $url="https://api.telegram.org/bot1296230416:AAHAuPEccOk-KIPp7S3K7oFD6__m1zPEcgQ/sendMessage?chat_id=-386042225&text=商户【".$user['openid']."】额度已满，请尽快下发";
            curl_get($url);
            $p_data=[
                'blog_id'=>$blog_id['id'],
                'money'=>$user['balance']+$item['real_money'],
                'autotx'=>"shtx",
            ];
            $url='http://127.0.0.1/ht.php?c=Finance&a=balance_cash';
            $result=curl_post($url,$p_data);
        }
		//信用单笔回款数量（金额）达到上限自动下线码商
		if($cnf_xyhk_model=='是'&&$cnf_mshk_signle=='是'&&$item['muid']){
			$cnf_whkbjjd_num=intval(getConfig('cnf_whkbjjd_num'));
			$cnf_whkbjjd_money=floatval(getConfig('cnf_whkbjjd_money'));
			$check_item=$mysql->fetchRow("select count(1) as cnt,sum(hk_money) as money from sk_order where muid={$item['muid']} and pay_status=9 and hk_status!=3");
			if($check_item['cnt']>=$cnf_whkbjjd_num||$check_item['money']>=$cnf_whkbjjd_money){
				$ma_sys_user=['is_online'=>0,'online_time'=>time()];
				$mysql->update($ma_sys_user,"id={$item['muid']}",'sys_user');
			}
		}
		
		//信用累计回款达到上限，自动下线码商
		if($cnf_xyhk_model=='是'&&$cnf_mshk_signle!='是'&&$item['muid']){
			$cnf_whkljjd_money=floatval(getConfig('cnf_whkljjd_money'));
			$ma_user=$mysql->fetchRow("select id,kb_balance from sys_user where id={$item['muid']}");
			if($ma_user['kb_balance']>=$cnf_whkljjd_money){
				$ma_sys_user=['is_online'=>0,'online_time'=>time()];
				$mysql->update($ma_sys_user,"id={$item['muid']}",'sys_user');
			}
		}
		
		//夜间接单额外奖励费率23-7点
		$ph=date('H',$item['pay_time']);
		if($ph>=23||($ph>=0&&$ph<=8)){
			$cnf_reward_rate=floatval(getConfig('cnf_reward_rate'));
			if($cnf_reward_rate<0){
				$cnf_reward_rate=0;
			}
			if($cnf_reward_rate>1){
				$cnf_reward_rate=1;
			}
			$ma_user=$mysql->fetchRow("select * from sys_user where id={$item['muid']}");
			if($ma_user&&$cnf_reward_rate>0){
				$money=$item['money']*$cnf_reward_rate;
				$m_sys_user=[
					'balance'=>$ma_user['balance']+$money
				];
				$mysql->update($m_sys_user,"id={$ma_user['id']}",'sys_user');
				$remark=$item['order_sn'].':'.$item['money'].'×'.$cnf_reward_rate;
				balanceLog($ma_user,1,6,$money,$item['id'],$remark,$mysql);
				$cnf_reward_log=[
					'uid'=>$ma_user['id'],
					'order_id'=>$item['id'],
					'rate'=>$cnf_reward_rate,
					'money'=>$money,
					'create_time'=>time(),
					'create_day'=>date('Ymd')
				];
				$mysql->insert($cnf_reward_log,'cnf_reward_log');
			}	
		}
    }
	
	$mysql->close();
    unset($mysql);
    echo time()."处理完一批，暂停1秒\n";
    sleep(1);
}
?>